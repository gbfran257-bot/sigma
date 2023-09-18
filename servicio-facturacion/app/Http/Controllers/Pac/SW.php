<?php

namespace App\Http\Controllers\Pac;

use App\Http\Helpers\Helper;
use App\Models\Timbrado;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

/**
 * Summary of SW
 */
class SW
{
    /**
     * Summary of token
     * @var
     */
    private $token;
    /**
     * Summary of url_
     * @var
     */
    private $url_;

    /**
     * Summary of __construct
     */
    public function __construct()
    {
        $this->token = $this->generateToken();

    }

    /**
     * Summary of stampCfdi
     * @param mixed $xmlContent
     * @return mixed
     */
    public function stampCfdi($xmlContent)
    {
        $delimiter = '-------------' . uniqid();
        $fileFields = array(
            'xml' => array(
                'type' => 'text/xml',
                'content' => $xmlContent
            )
        );
        $data = '';
        foreach ($fileFields as $name => $file) {
            $data .= "--" . $delimiter . "\r\n";
            $data .= 'Content-Disposition: form-data; name="' . $name . '";' .
                ' filename="' . $name . '"' . "\r\n";
            $data .= 'Content-Type: ' . $file['type'] . "\r\n";
            $data .= "\r\n";
            $data .= $file['content'] . "\r\n";
        }
        $data .= "--" . $delimiter . "--\r\n";

        $curl = curl_init($this->url_ . '/cfdi33/v2/stamp/v4');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);

        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: multipart/form-data; boundary=' . $delimiter,
                'Content-Length: ' . strlen($data),
                'Authorization: Bearer ' . $this->token
            )
        );
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return $err;
        } else {
            if ($httpcode < 500) {
                return json_decode($response);
            } else {
                return response()->json([
                    'message' => 'Error',
                    'messageDetail' => $response
                ], $httpcode);
            }
        }
    }

    /**
     * Summary of cancelationPfx
     * @param mixed $rfc
     * @param mixed $pfx
     * @param mixed $password
     * @param mixed $uuid
     * @return mixed
     */
    public function cancelationPfx($rfc, $pfx, $password, $uuid, $motivo, $folioSustitucion = null)
    {

        $data = [
            'uuid' => $uuid,
            'password' => $password,
            'rfc' => $rfc,
            'motivo' => $motivo,
            'b64Pfx' => $pfx
        ];

        if (!empty($folioSustitucion)) {
            $data['folioSustitucion'] = $folioSustitucion;
        }

        $curlOptions = [
            CURLOPT_URL => $this->url_ . '/cfdi33/cancel/pfx',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->token
            ],
        ];

        $ch = curl_init();
        curl_setopt_array($ch, $curlOptions);
        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response);
    }

    /**
     * Summary of cancelationXml
     * @param mixed $xmlContent
     * @return mixed
     */
    public function cancelationXml($xmlContent, $rfc, $uuid)
    {
        $timbradoProductivo = (bool)env('TIMBRADO_PRODUCTIVO');

        if(!$timbradoProductivo) {

            $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?><Acuse xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" Fecha=\"" . date("Y-m-d\TH:i:s") . "\" RfcEmisor=\"".$rfc."\"><Folios xmlns=\"http://cancelacfd.sat.gob.mx\"><UUID>".$uuid."</UUID><EstatusUUID>205</EstatusUUID></Folios><Signature xmlns=\"http://www.w3.org/2000/09/xmldsig#\"><SignedInfo><CanonicalizationMethod Algorithm=\"http://www.w3.org/TR/2001/REC-xml-c14n-20010315\"/><SignatureMethod Algorithm=\"http://www.w3.org/2000/09/xmldsig#rsa-sha1\"/><Reference URI=\"\"><Transforms><Transform Algorithm=\"http://www.w3.org/2000/09/xmldsig#enveloped-signature\"/></Transforms><DigestMethod Algorithm=\"http://www.w3.org/2000/09/xmldsig#sha1\"/><DigestValue>7g4x4+liSmK2a687Ws6cK5/ngro=</DigestValue></Reference></SignedInfo><SignatureValue>P4oiaqJcR29WIk4nvSfEnQAjbNbGT3AfWpmPDTfZGykRnUJmx6KNJQgbABXn21aAq90QRyYkxIk/akT5FVPPrxax3UL2PMhb60E+azP47kuXpgwJxKBZloo/vj7R7utLJvIdR6dCkjCKhSR7xm2omGfpwHnTcMrnqsYR2I94dXVBbTkrki0nKNb58OvEZhN0R2IRIMCl3aVNOYgZ/GDkqMwVweAq1syFM+EqtfeQj3dksyQVIb10VLZ1TgCqf//PWXc0at9adg6KDK3Yd9hZPqEbGe7j/Sv/U2qYTwBO3r6/SbkN7O0bO7pvarWLe3BQBAg06sz99g8QhH1B6ZV7gw==</SignatureValue><KeyInfo><X509Data><X509IssuerSerial><X509IssuerName>CN=AUTORIDAD CERTIFICADORA,O=SERVICIO DE ADMINISTRACION TRIBUTARIA,OU=SAT-IES Authority,emailAddress=contacto.tecnico@sat.gob.mx,street=AV. HIDALGO 772c COL. GUERRERO,postalCode=06300,C=MX,ST=CIUDAD DE MEXICO,L=CUAUHTEMOC,x500UniqueIdentifier=SAT970701NN3,unstructuredName=responsable: ADMINISTRACION CENTRAL DE SERVICIOS TRIBUTARIOS AL CONTRIBUYENTE</X509IssuerName><X509SerialNumber>00001000000510342907</X509SerialNumber></X509IssuerSerial><X509Certificate>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</X509Certificate></X509Data><KeyValue><RSAKeyValue><Modulus>tRVnOLE/CkwE9vwk9/Si+wXgimy+rDX1YTw5WLKu4OfBoFXqX4JKBOk5dMqp+PBXS9UM1CcHlLNffHvCAfot0o4kVJ4VLx5Rqq4nyyEkloJaYHo7WUSYH2bs1hOrURQH9cIw18Iv9dgyzU6KEE2fAtzLTvksCibf25snpgGxv4RSkGxcE9e+qvDv7pw6kfyvMVI8IYly2LjvH6DxYT9ikk9LEjkXfImZuTkelyMTQEOeCqOqI7EfGMcT+NrLqLuR3FsK2G+IaME9wvp8GG+elyLDRDUk438+B6FX1UVQhDMqAWALg3dNGR5BjMuA+wTVNlGsBucsZJ1mc+g6LBYGOQ==</Modulus><Exponent>AQAB</Exponent></RSAKeyValue></KeyValue></KeyInfo></Signature></Acuse>";

            $json = [
                "data" => [
                    "acuse" => $xml,
                    "uuid" => [
                        "".$uuid."" => "205"
                    ]
                ],
                "status" => "success"
            ];

            $jsonString = json_decode(json_encode($json));

            return $jsonString;
        }

        $delimiter = '-------------' . uniqid();
        $fileFields = array(
            'xml' => array(
                'type' => 'text/xml',
                'content' => $xmlContent
            )
        );
        $data = '';
        foreach ($fileFields as $name => $file) {
            $data .= "--" . $delimiter . "\r\n";
            $data .= 'Content-Disposition: form-data; name="' . $name . '";' .
                ' filename="' . $name . '"' . "\r\n";
            $data .= 'Content-Type: ' . $file['type'] . "\r\n";
            $data .= "\r\n";
            $data .= $file['content'] . "\r\n";
        }
        $data .= "--" . $delimiter . "--\r\n";

        $curl = curl_init($this->url_ . '/cfdi33/cancel/xml');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);

        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            [
                'Content-Type: multipart/form-data; boundary=' . $delimiter,
                'Content-Length: ' . strlen($data),
                'Authorization: Bearer ' . $this->token
            ]
        );
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return $err;
        } else {
            if ($httpcode < 500) {
                return json_decode($response);
            } else {
                return response()->json([
                    'message' => 'Error',
                    'messageDetail' => $response
                ], $httpcode);
            }
        }
    }

    /**
     * Summary of generateToken
     * @return mixed
     */
    private function generateToken()
    {
        $this->url_  = env('TIMBRADO_URL');
        $usuario = env('TIMBRADO_USUARIO');
        $password = env('TIMBRADO_PASSWORD');

        $client = new Client();
        $headers = [
            'user' => $usuario,
            'password' => $password
        ];
        $request = new Request('POST', $this->url_ . '/security/authenticate', $headers);
        $res = $client->sendAsync($request)->wait();
        $respuesta = $res->getBody()->getContents();

        $data = json_decode($respuesta, true);

        if ($data['status'] === 'success') {
            return $data['data']['token'];
        } else {
            return response()->json([
                'message' => 'Success',
                'Authentication failed' => $res->getBody()
            ], 500);
        }
    }
}
