<?php

namespace App\Http\Controllers\Cancelation;

use App\Http\Controllers\Pac\SW;
use App\Http\Helpers\Helper;
use App\Services\CancelationService;
use App\Services\CertificadosService;
use App\Services\FacturaService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

/**
 * Summary of CancelationController
 */
class CancelationController extends Controller
{
    /**
     * Summary of pfx
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function pfx(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uuid' => 'required',
            'motivo' => 'required',
            'folioSustitucion' => 'required_if:motivo,01,04',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=> 'error',
                'message' => 'Atributos faltantentes',
                'messageDetail' => $validator->errors()
            ], 400);
        }

        $data = $request->all();
        $uuid = $data['uuid'];
        $motivo = $data['motivo'];
        $folioSustitucion = isset($data['folioSustitucion']) ?? null;

        $user = Helper::userInfo();
        $clienteId = $user->id;

        $certificadoService = new CertificadosService();
        $certificado = $certificadoService->getCertificadosByUserId($clienteId);

        if (!$certificado) {
            return response()->json(['message' => 'Certificado no encontrado'], 404);
        }

        $filtros = ['uuid' => $uuid];
        $facturasFiltradas = $this->searchFilteredInvoices($clienteId, $filtros);
        $responses = [];

        $invoicesToCancel = sizeof($facturasFiltradas) > 0 ? $facturasFiltradas : [['id' => 0,'uuid' => $uuid]];

        foreach ($invoicesToCancel as $factura) {

            $result = $this->cancelInvoice($certificado, $factura, $motivo, $folioSustitucion);

            $responses[] = $result;
        }

        $statusCode = collect($responses)->contains(function ($response) {
            return $response->status === 'error';
        }) ? 400 : 201;


        if (count($responses) === 1) {
            return response()->json($responses[0], $statusCode);
        } else {
            return response()->json($responses, $statusCode);
        }
    }


    /**
     * Summary of searchFilteredInvoices
     * @param mixed $clienteId
     * @param mixed $filtros
     * @return mixed
     */
    private function searchFilteredInvoices($clienteId, $filtros)
    {
        $facturaService = new FacturaService();
        $results = $facturaService->searchXmls($clienteId, $filtros);

        $filteredResults = [];

        foreach ($results as $result) {
            $filteredResults[] = [
                'id' => $result->id,
                'uuid' => $result->uuid,
            ];
        }

        return $filteredResults;
    }

    /**
     * Summary of cancelInvoice
     * @param mixed $certificado
     * @param mixed $factura
     * @param mixed $motivo
     * @param mixed $folioSustitucion
     * @return mixed
     */
    private function cancelInvoice($certificado, $factura, $motivo, $folioSustitucion)
    {
        $passworddecrypted = Crypt::decrypt($certificado->password);

        $rfc = $certificado->rfc;
        $pfx = $certificado->pfx;

        $uuidFactura = null;
        if (is_object($factura) && property_exists($factura, 'uuid')) {
            $uuidFactura = $factura->uuid;
        } elseif (is_array($factura) && isset($factura['uuid'])) {
            $uuidFactura = $factura['uuid'];
        }

        $cancelationService = new CancelationService();
        $xml = $cancelationService->getCancelationXml($certificado, $factura['uuid']);
        $cancelationService = new SW();

        $result = $cancelationService->cancelationXml($xml, $certificado->rfc, $factura['uuid']);

        if ($result->status == 'success') {
            $this->updateInvoiceStatus($factura);
        }

        return $result;
    }

    private function updateInvoiceStatus($factura)
    {
        if($factura['id'] > 0) {
            $factura->update(['activa' => 0]);
        }
    }


}
