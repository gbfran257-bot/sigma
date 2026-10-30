<?php

namespace App\Services;

use App\Http\Controllers\Pac\SW;
use App\Http\Helpers\Helper;
use App\Models\Factura;
use App\Services\Translators\LocalPlatesHtmlTranslator;
use CfdiUtils\Certificado\Certificado;
use CfdiUtils\CfdiCreator40;
use CfdiUtils\Cleaner\Cleaner;
use CfdiUtils\Nodes\XmlNodeUtils;
use CfdiUtils\Utils\Format;
use Exception;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use PhpCfdi\CfdiToPdf\Builders\Html2PdfBuilder;
use PhpCfdi\CfdiToPdf\CfdiDataBuilder;
use PhpCfdi\CfdiToPdf\Converter;
use PhpCfdi\Credentials\Pfx\PfxReader;

/**
 * Summary of BuildCfdiService
 */
class BuildCfdiService
{
    /**
     * Summary of getComprobante
     * @param mixed $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function getComprobante($request, $productivo = true)
    {
        $user = Helper::userInfo();
        $userId = $user->id;
        $csd = Helper::getCertificadosPorUsuario($userId);

        $xml = $this->createCfi($request, $csd);

        if($productivo) {
            $stampService = $this->stampService($xml);

            if ($stampService['errors'] == 0) {

                $xml = Cleaner::staticClean($stampService['data']);
                $comprobante = XmlNodeUtils::nodeFromXmlString($xml);

                $base64PdfContent = $this->pdfService($comprobante);

                $facturaId = $this->saveXML($userId, $xml, $base64PdfContent);

                $facturaService = new FacturaService();

                $factura = $facturaService->buscarFacturaPorId($facturaId);

                $data = [];

                if (!empty($factura)) {
                    $primeraFactura = $factura[0];
                    $data = [
                        'uuid' => $primeraFactura->uuid
                    ];
                }

                return response()->json([
                    "data" => $data,
                    "status" => 'success',
                    "message" => '',
                    "messageDetail" => ''
                ], 201);
            } else {
                return response()->json([
                    "data" => null,
                    "status" => 'error',
                    "message" => $stampService['message'],
                    "messageDetail" => $stampService['messageDetail']
                ], 201);
            }
        } else {
            $xml = Cleaner::staticClean($xml);
            $comprobante = XmlNodeUtils::nodeFromXmlString($xml);
            $base64PdfContent = $this->pdfService($comprobante, false);

            return response()->json([
                "data" => [
                    'xml' => base64_encode($xml),
                    'pdf' => '',
                ],
                "status" => 'error',
                "message" => 'success',
                "messageDetail" => null
            ], 201);


        }
    }

    /**
     * Summary of createCfi
     * @param mixed $data
     * @param mixed $csd
     * @return string
     */
    private function createCfi($data, $csd)
    {
        $passworddecrypted = Crypt::decrypt($csd->password);

        $pfxReader = new PfxReader();
        $credential = $pfxReader->createCredentialFromContents(base64_decode($csd->pfx), $passworddecrypted);

        $creator = new CfdiCreator40();
        $comprobante = $creator->comprobante();
        $comprobante->addAttributes([
            'Fecha' => Format::datetime(strtotime($data->Fecha)),
            'TipoDeComprobante' => $data->TipoDeComprobante,
            'LugarExpedicion' => $data->LugarExpedicion,
            'Moneda' => $data->Moneda,
            'Exportacion' => '01',
            'Serie' => $data->Serie,
            'Folio' => $data->Folio,
            'FormaPago' => $data->FormaPago,
            'TipoCambio' => $data->TipoCambio,
            'MetodoPago' => $data->MetodoPago,
        ]);

        $passworddecrypted = Crypt::decrypt($csd->password);

        $pfxReader = new PfxReader();
        $pfxContents = base64_decode($csd->pfx);

        $credential = $pfxReader->createCredentialFromContents($pfxContents, $passworddecrypted);

        $pfx = $pfxReader->loadPkcs12($pfxContents, $passworddecrypted);

        $cert = $this->cleanCertificatePem($credential->certificate()->pem());

        $creator->putCertificado(new Certificado($cert), true);


        if (!empty($data->Emisor['RegimenFiscal'])) {
            $emisorData['RegimenFiscal'] = $data->Emisor['RegimenFiscal'];
        }

        $comprobante->addEmisor($emisorData);

        $comprobante->addReceptor([
            'Rfc' => $data->Receptor['Rfc'],
            'Nombre' => $data->Receptor['Nombre'],
            'RegimenFiscalReceptor' => $data->Receptor['RegimenFiscalReceptor'],
            'UsoCFDI' => $data->Receptor['UsoCFDI'],
            'DomicilioFiscalReceptor' => $data->Receptor['DomicilioFiscalReceptor'],
        ]);

        if (!empty($data->Receptor['RegimenFiscalReceptor'])) {
            $receptorData['RegimenFiscalReceptor'] = $data->Receptor['RegimenFiscalReceptor'];
        }

        $comprobante->addReceptor($receptorData);

        $conceptoData = $data->Conceptos;

        foreach ($data->Conceptos['Concepto'] as $conceptoData) {

            $conceptoFields = [
                'ObjetoImp' => isset($conceptoData['Impuestos']['Traslados']['Traslado']) ||
                isset($conceptoData['Impuestos']['Retenciones']) ? '02' : '01',
            ];

            $fields = [
                'Cantidad',
                'ClaveProdServ',
                'ClaveUnidad',
                'Unidad',
                'Descripcion',
                'ValorUnitario',
                'Importe'
            ];

            foreach ($fields as $field) {
                if (isset($conceptoData[$field])) {
                    $conceptoFields[$field] = $conceptoData[$field];
                }
            }

            $concepto = $comprobante->addConcepto($conceptoFields);

            $fields = [
                'Base',
                'Importe',
                'Impuesto',
                'TasaOCuota',
                'TipoFactor',
            ];

            if (isset($conceptoData['Impuestos']['Traslados']['Traslado'])) {
                foreach ($conceptoData['Impuestos']['Traslados']['Traslado'] as $traslado) {
                    $impuestosTraslado = array_intersect_key($traslado, array_flip($fields));

                    if ($impuestosTraslado['Importe'] === null) {
                        $importe = floatval($impuestosTraslado['Base']) * floatval($impuestosTraslado['TasaOCuota']);
                        $impuestosTraslado['Importe'] = number_format($importe, 2);
                    }

                    $concepto->addTraslado($impuestosTraslado);
                }
            }

            if (isset($conceptoData['Impuestos']['Retenciones'])) {
                foreach ($conceptoData['Impuestos']['Retenciones'] as $retencion) {
                    $impuestosRetencion = array_intersect_key($retencion, array_flip($fields));

                    if ($impuestosRetencion['Importe'] === null) {
                        $importe = floatval($impuestosRetencion['Base']) * floatval($impuestosRetencion['TasaOCuota']);
                        $impuestosRetencion['Importe'] = number_format($importe, 2);
                    }
                    $concepto->addRetencion($impuestosRetencion);
                }
            }
        }

        $creator->moveSatDefinitionsToComprobante();

        $creator->addSumasConceptos(null, 2);
        $creator->addSello($pfx['pkey'], $passworddecrypted);

        $xml = $creator->asXml();
        return $xml;
    }

    /**
     * Summary of stampService
     * @param mixed $xml
     * @return array
     */
    private function stampService($xml)
    {
        $servicioTimbrar = new SW();
        $timbrado = $servicioTimbrar->stampCfdi($xml);

        $cfdiContent = null;
        $errors = 1;
        $message = null;
        $messageDetail = null;

        if (isset($timbrado->data)) {
            $cfdiContent = $timbrado->data->cfdi;

            $errors = 0;
        } else {

            $message = $timbrado->message;
            $messageDetail = $timbrado->messageDetail;
        }

        $result = [
            'data' => $cfdiContent,
            'errors' => $errors,
            'message' => $message,
            'messageDetail' => $messageDetail,
        ];

        return $result;
    }

    /**
     * Summary of pdfService
     * @param mixed $comprobante
     * @return string
     */
    private function pdfService($comprobante, $productivo = true)
    {
        $cfdiData = (new CfdiDataBuilder())
        ->build($comprobante);

        if($productivo) {

            $converter = new Converter(
                new Html2PdfBuilder()
            );

            $converter->createPdfAs($cfdiData, 'output.pdf');

            $filePath = public_path('output.pdf');
            if (File::exists($filePath)) {
                $fileContent = File::get($filePath);

                $base64PdfContent = base64_encode($fileContent);

                File::delete($filePath);
            }

            return $base64PdfContent;
        } else {
            $cfdiData = (new CfdiDataBuilder())->build($comprobante);
            $extras =  '';

            $res = (new LocalPlatesHtmlTranslator(
                'Services/Templates/',
                'generic',
                $extras
            ))->buildPdf($cfdiData);

            var_dump($res);

            return '';
        }
    }


    /**
     * Summary of isValidJson
     * @param mixed $string
     * @return bool
     */
    private function isValidJson($string)
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }

    /**
     * Summary of cleanCertificatePem
     * @param mixed $pem
     * @return array|string
     */
    private function cleanCertificatePem($pem)
    {
        return str_replace(["-----BEGIN CERTIFICATE-----", "-----END CERTIFICATE-----", "\n", "\r"], '', $pem);
    }

    /**
     * Summary of saveXML
     * @param mixed $userId
     * @param mixed $xml
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    private function saveXML($userId, $xml, $pdf)
    {
        try {
            $factura = new Factura();
            $factura->cliente_id = $userId;
            $factura->xml = $xml;
            $factura->pdf = $pdf;
            $factura->save();

            $lastInsertedId = $factura->id;
            return $lastInsertedId;
        } catch (Exception $e) {
            return response()->json(['error' => 'Error al guardar la factura'], 500);
        }
    }
}
