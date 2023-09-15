<?php

namespace App\Http\Controllers\Certificates;

use App\Http\Controllers\Controller;
use App\Http\Helpers\CertificadosLibrary;
use App\Http\Helpers\Helper;
use App\Models\Certificados;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PhpCfdi\Credentials\Credential;
use PhpCfdi\Credentials\Pfx\PfxExporter;


class CertificatesController extends Controller
{
    public function store(Request $request)
    {
        try {

            $id = $request->input('id');
            $data = $request->only(['b64Cert', 'b64Key', 'password', 'codigoPostal']);

            $validator = Validator::make($data, [
                'b64Cert' => ['required', 'string', 'regex:/^[A-Za-z0-9+\/]{4}([A-Za-z0-9+\/]{4})*([A-Za-z0-9+\/]{2}==|[A-Za-z0-9+\/]{3}=)?$/'],
                'b64Key' => ['required', 'string', 'regex:/^[A-Za-z0-9+\/]{4}([A-Za-z0-9+\/]{4})*([A-Za-z0-9+\/]{2}==|[A-Za-z0-9+\/]{3}=)?$/'],
                'password' => 'required|string',
                'codigoPostal' => 'required|numeric',
            ], [
                'b64Cert.regex' => 'El campo :attribute debe ser un valor válido en formato Base64.',
                'b64Key.regex' => 'El campo :attribute debe ser un valor válido en formato Base64.',
                'codigoPostal.numeric' => 'El campo :attribute debe ser un número.',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status'=> 'error',
                    'message' => 'Atributos faltantentes',
                    'messageDetail' => $validator->errors()
                ], 400);
            }

            try {

                $passPhrase = $data['password'];

                $credential = Credential::create(
                    base64_decode($data['b64Cert']),
                    base64_decode($data['b64Key']),
                    $passPhrase
                );

                $pfxExporter = new PfxExporter($credential);
                $pfxContents = $pfxExporter->export($passPhrase);

                $pfx = base64_encode($pfxContents);

                $certificado = $credential->certificate();

                $rfc = $certificado->rfc();
                $razonSocial = $certificado->legalName();
                $numeroSerie = $certificado->serialNumber()->bytes();
                $validoDesde = $certificado->validFromDateTime();
                $validoHasta = $certificado->validToDateTime();

                $userId = $id ?? Helper::userInfo()->id;

                $existingCert = Certificados::where('user_id', $userId)->first();

                $passPhrase = Crypt::encrypt($data['password']);

                if ($pfx != null) {
                    if ($existingCert) {
                        $existingCert->update([
                            'pfx' => $pfx,
                            'password' => $passPhrase,
                            'numero_certificado' => $numeroSerie,
                            'rfc' => $rfc,
                            'razon_social' => $razonSocial,
                            'codigo_postal' => $data['codigoPostal'],
                            'fecha_inicio' => $validoDesde,
                            'fecha_fin' => $validoHasta,
                        ]);
                    } else {
                        Certificados::create([
                            'user_id' => $userId,
                            'pfx' => $pfx,
                            'password' => $passPhrase,
                            'numero_certificado' => $numeroSerie,
                            'rfc' => $rfc,
                            'razon_social' => $razonSocial,
                            'codigo_postal' => $data['codigoPostal'],
                            'fecha_inicio' => $validoDesde,
                            'fecha_fin' => $validoHasta,
                            'activo' => 0
                        ]);
                    }

                    return response()->json([
                        'data' => null,
                        'status' => 'success',
                        'message' => 'Correcto',
                        'messageDetail' => 'Certificados insertados o actualizados correctamente.'
                    ], 201);
                }
            } catch (Exception $e) {
                return response()->json([
                    'data' => null,
                    'status' => 'error',
                    'message' => 'Error al crear el certificado',
                    'messageDetail' => $e->getMessage()
                ], 400);
            }

        } catch (Exception $e) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Ocurrió un error al procesar la solicitud',
                'messageDetail' => $e->getMessage()
            ], 500);
        }
    }

}
