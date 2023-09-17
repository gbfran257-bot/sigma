<?php

namespace App\Http\Controllers\Stamp;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Services\BuildCfdiService;
use App\Services\FacturaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Summary of CfdiController
 */
class CfdiController extends Controller
{
    /**
     * Summary of stamp
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function stamp(Request $request)
    {
        $jsonContent = $request->getContent();

        if (!$this->isValidJson($jsonContent)) {
            return response()->json(['error' => 'Invalid JSON Body'], 400);
        }

        $validator = Validator::make($request->all(), [
            'Fecha' => 'required',
            'Folio' => 'required',
            'FormaPago' => 'required',
            'LugarExpedicion' => 'required',
            'MetodoPago' => 'required',
            'Moneda' => 'required',
            'Serie' => 'required',
            'SubTotal' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
            'TipoDeComprobante' => 'required',
            'Emisor.RegimenFiscal' => 'required',
            'Receptor.Nombre' => 'required',
            'Receptor.Rfc' => 'required',
            'Receptor.UsoCFDI' => 'required',
            'Receptor.DomicilioFiscalReceptor' => 'required',
            'Receptor.RegimenFiscalReceptor' => 'required',
            'Conceptos.Concepto.*.Cantidad' => 'required',
            'Conceptos.Concepto.*.ClaveProdServ' => 'required',
            'Conceptos.Concepto.*.ClaveUnidad' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Atributos faltantentes',
                'messageDetail' => $validator->errors()
            ], 400);
        }

        $buildCfdi = new BuildCfdiService();

        return $buildCfdi->getComprobante($request);
    }

    /**
     * Summary of get
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function get(Request $request)
    {

        $claves = [
            'rfcEmisor' => 'valor_rfc_emisor',
            'rfcReceptor' => 'valor_rfc_receptor',
            'emisorNombre' => 'valor_emisor_nombre',
            'receptorNombre' => 'valor_receptor_nombre',
            'total' => 'valor_total',
            'tipoDeComprobante' => 'valor_tipo_de_comprobante',
            'activa' => 'valor_activa',
            'fechaInicial' => 'valor_fecha_inicial',
            'fechaFinal' => 'valor_fecha_final',
            'uuid' => 'valor_uuid'
        ];

        $filtros = [];

        foreach ($claves as $clave => $valor) {
            if ($request->has($clave)) {
                $filtros[$clave] = $request->input($clave);
            }
        }

        $user = Helper::userInfo();
        $clienteId = $user->id;

        $facturaService = new FacturaService();
        $results = $facturaService->searchXmls($clienteId, $filtros);

        $filteredResults = [];

        foreach ($results as $result) {
            $filteredResults[] = [
                'id' => $result->id,
                'uuid' => $result->uuid,
                'xml' => $result->xml,
                'pdf' => $result->pdf,
            ];
        }

        return $filteredResults;
    }


    /**
     * Summary of pagos
     * @param \Illuminate\Http\Request $request
     * @return null
     */
    public function pagos(Request $request)
    {
        return null;
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

}
