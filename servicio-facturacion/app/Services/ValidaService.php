<?php
namespace App\Services;

use App\Http\Helpers\Helper;
use Illuminate\Support\Facades\DB;


/**
 * Summary of ValidaService
 */
class ValidaService
{
    /**
     * Summary of url
     * @var
     */
    protected $url;
    /**
     * Summary of headers
     * @var
     */
    protected $headers;

    /**
     * Summary of __construct
     */
    public function __construct()
    {
        $this->url = 'https://consultaqr.facturaelectronica.sat.gob.mx/ConsultaCFDIService.svc';
        $this->headers = [
            'Content-type: text/xml;charset="utf-8"',
            'Accept: text/xml',
            'SOAPAction: http://tempuri.org/IConsultaCFDIService/Consulta'
        ];
    }


    /**
     * Summary of consultarCfdiPorUUID
     * @param mixed $uuid
     * @return \stdClass|null
     */
    public function consultarCfdiPorUUID($uuid)
    {
        $facturaData = $this->getFacturaDataByUUID($uuid);

        if (!$facturaData) {
            return null;
        }

        $factura = $facturaData[0];

        $xmlRequest = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/">
            <soapenv:Header/>
            <soapenv:Body>
                <tem:Consulta>
                    <tem:expresionImpresa><![CDATA[?re=' . $factura->emisor_rfc . '&rr=' . $factura->receptor_rfc . '&tt=' . $factura->total . '&id=' . $factura->uuid . ']]></tem:expresionImpresa>
                </tem:Consulta>
            </soapenv:Body>
        </soapenv:Envelope>';

        $curl = curl_init();

        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => $this->url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $xmlRequest,
                CURLOPT_HTTPHEADER => $this->headers,
            )
        );

        $response = curl_exec($curl);

        curl_close($curl);

        $responseObj = new \stdClass();
        $responseObj->codigoEstatus = $this->parseResponseValue($response, 'CodigoEstatus');
        $responseObj->esCancelable = $this->parseResponseValue($response, 'EsCancelable');
        $responseObj->estado = $this->parseResponseValue($response, 'Estado');
        $responseObj->estatusCancelacion = $this->parseResponseValue($response, 'EstatusCancelacion');
        $responseObj->validacionEFOS = $this->parseResponseValue($response, 'ValidacionEFOS');

        return $responseObj;
    }

    /**
     * Summary of parseResponseValue
     * @param mixed $response
     * @param mixed $tag
     * @return string|null
     */
    protected function parseResponseValue($response, $tag)
    {
        $startTag = '<a:' . $tag . '>';
        $endTag = '</a:' . $tag . '>';
        $startPos = strpos($response, $startTag);
        $endPos = strpos($response, $endTag);

        if ($startPos !== false && $endPos !== false) {
            $value = substr($response, $startPos + strlen($startTag), $endPos - ($startPos + strlen($startTag)));
            return $value;
        }

        return null;
    }


    /**
     * Summary of getFacturaDataByUUID
     * @param mixed $uuid
     * @return array
     */
    private function getFacturaDataByUUID($uuid)
    {
        $user = Helper::userInfo();
        $clienteId = $user->id;

        $query = "SELECT
                ExtractValue(xml, '//cfdi:Comprobante/cfdi:Emisor/@Rfc') AS emisor_rfc,
                ExtractValue(xml, '//cfdi:Comprobante/cfdi:Receptor/@Rfc') AS receptor_rfc,
                ExtractValue(xml, '//cfdi:Comprobante/@Total') AS total,
                ExtractValue(xml, '//tfd:TimbreFiscalDigital/@UUID') AS uuid
            FROM facturas
            WHERE ExtractValue(xml, '//tfd:TimbreFiscalDigital/@UUID') = :uuid
            AND cliente_id = :clienteId
            LIMIT 1";

        $bindings = ['uuid' => $uuid, 'clienteId' => $clienteId];

        $result = DB::select($query, $bindings);

        return $result;
    }

}
