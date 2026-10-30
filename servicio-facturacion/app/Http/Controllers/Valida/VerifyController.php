<?php

namespace App\Http\Controllers\Valida;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ValidaService;

class VerifyController extends Controller
{
    /**
     * Summary of consultarCfdiPorUUID
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function consultarCfdiPorUUID(Request $request)
    {
        $uuid = $request->input('uuid');

        if (empty($uuid)) {
            return response()->json([
                'status'=> 'error',
                'message' => 'Atributos faltantentes',
                'messageDetail' => 'El campo UUID es requerido'
            ], 400);
        }

        $validaService = new ValidaService();
        $response = $validaService->consultarCfdiPorUUID($uuid);

        if ($response === null) {
            return response()->json(['message' => 'No se encontra una factura con el UUID: ' . $uuid. '.'], 404);
        }

        return response()->json($response);
    }


}
