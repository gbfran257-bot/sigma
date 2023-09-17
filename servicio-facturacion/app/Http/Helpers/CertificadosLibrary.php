<?php

namespace App\Http\Helpers;

use Exception;
use Illuminate\Support\Facades\Storage;
use PhpCfdi\Credentials\Pfx\PfxReader;

/**
 * Summary of Certificados
 */
class CertificadosLibrary
{
    /**
     * Summary of _path
     * @var string
     */
    private $_path = '';
    /**
     * Summary of _keyPem
     * @var string
     */
    public $_keyPem = '';
    /**
     * Summary of _cerPem
     * @var string
     */
    public $_cerPem = '';
    /**
     * Summary of _pfx
     * @var string
     */
    public $_pfx = '';
    /**
     * Summary of _password
    * @var string
    */
    public $_password;
    /**
     * Summary of _return
     * @var array
     */
    private $_return = array();

    /**
     * Summary of __construct
     * @param mixed $pathCertificados
     */
    public function __construct($pathCertificados = null)
    {
        $this->_path = $pathCertificados;
    }

    /**
     * Summary of _estableceError
     * @param mixed $result
     * @param mixed $mensajeError
     * @param mixed $arrayExtras
     * @return void
     */
    private function _estableceError($result, $mensajeError = null, $arrayExtras = null)
    {
        $this->_return = array();
        $this->_return['result'] = $result;
        if($mensajeError != null) {
            $this->_return['error'] = $mensajeError;
        }
        if($arrayExtras != null) {
            foreach ($arrayExtras as $key => $val) {
                $this->_return[$key] = $val;
            }
        }
    }

    /**
     * Summary of generaKeyPem
     * @param mixed $nombreKey
     * @param mixed $password
     * @return array
     */
    public function generaKeyPem($nombreKey, $password)
    {
        $nombreKey = $this->_path.$nombreKey;

        if (file_exists($nombreKey)) {
            $salida = shell_exec('openssl pkcs8 -inform DER -in '.$nombreKey.' -out '.$nombreKey.'.pem -passin pass:'.$password.' 2>&1');
            if($salida == '' || $salida == false || $salida == null) {
                $this->_keyPem = $nombreKey.'.pem';
                $this->_estableceError(1);
                return $this->_return;
            } elseif (strpos($salida, 'Error decrypting') !== false) {
                $this->_estableceError(0, 'Contraseña incorrecta');
                return $this->_return;
            } else {
                $this->_estableceError(0, 'No se logro generar el key.pem');
                return $this->_return;
            }

        } else {
            $this->_estableceError(0, 'El archivo requerido no esta disponible');
            return $this->_return;
        }
    }

    /**
     * Summary of generaCerPem
     * @param mixed $nombreCer
     * @return array
     */
    public function generaCerPem($nombreCer)
    {

        $nombreCer = $this->_path.$nombreCer;
        if (file_exists($nombreCer)) {
            $salida = shell_exec('openssl x509 -inform DER -outform PEM -in '.$nombreCer.' -pubkey -out '.$nombreCer.'.pem 2>&1');
            if (strpos($salida, 'BEGIN PUBLIC KEY') !== false) {
                $this->_cerPem = $nombreCer.'.pem';
                $this->_estableceError(1);
                return $this->_return;
            } else {
                $this->_estableceError(0, 'No se logro generar el cer.pem');
                return $this->_return;
            }
        } else {
            $this->_estableceError(0, 'El archivo requerido no esta disponible.');
            return $this->_return;
        }
    }

    /**
     * Summary of getSerialCert
     * @param mixed $nombreCerPem
     * @return array
     */
    public function getSerialCert($nombreCerPem = null)
    {
        if($nombreCerPem == null) {
            if($this->_cerPem != null) {
                $nombreCerPem = $this->_cerPem;
            } else {
                $nombreCerPem = $this->_path.'desconocido.ccg';
            }
        } else {
            $nombreCerPem = $this->_path.$nombreCerPem;
        }

        if (file_exists($nombreCerPem)) {
            $salida = shell_exec('openssl x509 -in '.$nombreCerPem.' -noout -serial  2>&1');

            if (strpos($salida, 'serial=') !== false) {
                $salida = str_replace('serial=', '', $salida);
                $serial = '';
                for ($i = 0; $i < strlen($salida); $i++) {
                    if($i % 2 != 0) {
                        $serial .= $salida[$i];
                    }
                }
                $this->_estableceError(1, null, array('serial' => $serial));
                return $this->_return;
            } else {
                $this->_estableceError(0, 'No se logro obtener el seria del certificado');
                return $this->_return;
            }
        } else {
            $this->_estableceError(0, 'El archivo requerido no esta disponible');
            return $this->_return;
        }
    }

    /**
     * Summary of getFechaInicio
     * @param mixed $nombreCerPem
     * @return array
     */
    public function getFechaInicio($nombreCerPem = null)
    {
        if($nombreCerPem == null) {
            if($this->_cerPem != null) {
                $nombreCerPem = $this->_cerPem;
            } else {
                $nombreCerPem = $this->_path.'desconocido.ccg';
            }
        } else {
            $nombreCerPem = $this->_path.$nombreCerPem;
        }

        if (file_exists($nombreCerPem)) {
            $salida = shell_exec('openssl x509 -in '.$nombreCerPem.' -noout -startdate 2>&1');
            $salida = trim(str_replace('notBefore=', '', $salida));
            $info_preg = array();
            $salida = str_replace('  ', ' ', $salida);
            preg_match(
                '#([A-z]{3}) ([0-9]{1,2}) ([0-2][0-9]:[0-5][0-9]:[0-5][0-9]) ([0-9]{4})#',
                $salida,
                $info_preg
            );
            if(!empty($info_preg)) {
                $fecha = $info_preg[2].'-'.$info_preg[1].'-'.$info_preg[4].' '.$info_preg[3];
                $this->_estableceError(1, null, array('fecha' => $fecha));
                return $this->_return;
            } else {
                $this->_estableceError(0, 'No se logro obtener la fecha de inicio del certificado');
                return $this->_return;
            }
        } else {
            $this->_estableceError(0, 'El archivo requerido no esta disponible');
            return $this->_return;
        }
    }

    /**
     * Summary of getFechaVigencia
     * @param mixed $nombreCerPem
     * @return array
     */
    public function getFechaVigencia($nombreCerPem = null)
    {
        if($nombreCerPem == null) {
            if($this->_cerPem != null) {
                $nombreCerPem = $this->_cerPem;
            } else {
                $nombreCerPem = $this->_path.'desconocido.ccg';
            }
        } else {
            $nombreCerPem = $this->_path.$nombreCerPem;
        }

        if (file_exists($nombreCerPem)) {
            $salida = shell_exec('openssl x509 -in '.$nombreCerPem.' -noout -enddate 2>&1');
            $salida = str_replace('notAfter=', '', $salida);
            $info_preg = array();
            $salida = str_replace('  ', ' ', $salida);
            preg_match(
                '#([A-z]{3}) ([0-9]{1,2}) ([0-2][0-9]:[0-5][0-9]:[0-5][0-9]) ([0-9]{4})#',
                $salida,
                $info_preg
            );
            if(!empty($info_preg)) {
                $fecha =  $info_preg[2].'-'.$info_preg[1].'-'.$info_preg[4].' '.$info_preg[3];
                $this->_estableceError(1, null, array('fecha' => $fecha));
                return $this->_return;
            } else {
                $this->_estableceError(0, 'No se logro obtener la fecha de vigencia del certificado');
                return $this->_return;
            }
        } else {
            $this->_estableceError(0, 'El archivo requerido no esta disponible');
            return $this->_return;
        }
    }

    /**
     * Summary of validarCertificado
     * @param mixed $nombreCerPem
     * @return array
     */
    public function validarCertificado($nombreCerPem = null)
    {
        if($nombreCerPem == null) {
            if($this->_cerPem != null) {
                $nombreCerPem = $this->_cerPem;
            } else {
                $nombreCerPem = $this->_path.'desconocido.ccg';
            }
        } else {
            $nombreCerPem = $this->_path.$nombreCerPem;
        }

        if (file_exists($nombreCerPem)) {
            $salida = shell_exec('openssl x509 -in '.$nombreCerPem.' -noout -subject 2>&1');
            $salida = str_replace('notBefore=', '', $salida);
            $info_preg = array();
            preg_match(
                '#/OU=(.*)#',
                $salida,
                $info_preg
            );
            if(!empty($info_preg)) {
                $this->_estableceError(1, null, array('OU' => $info_preg[1]));
                return $this->_return;
            } else {
                $this->_estableceError(0, 'No se logro validar el certificado');
                return $this->_return;
            }
        } else {
            $this->_estableceError(0, 'El archivo requerido no esta disponible');
            return $this->_return;
        }
    }

    /**
     * Summary of pareja
     * @param mixed $nombreCerPem
     * @param mixed $nombreKeyPem
     * @return array
     */
    public function pareja($nombreCerPem = null, $nombreKeyPem = null)
    {
        $nombreCerPem = $nombreCerPem ?? $this->_cerPem;
        $nombreKeyPem = $nombreKeyPem ?? $this->_keyPem;

        if (!file_exists($nombreCerPem) || !file_exists($nombreKeyPem)) {
            $this->_estableceError(0, 'Al menos uno de los archivos requeridos no está disponible');
            return $this->_return;
        }

        $salidaCer = shell_exec('openssl x509 -noout -modulus -in ' . escapeshellarg($nombreCerPem) . ' 2>&1');
        $salidaKey = shell_exec('openssl rsa -noout -modulus -in ' . escapeshellarg($nombreKeyPem) . ' 2>&1');

        if ($salidaCer === $salidaKey) {
            $this->_estableceError(1);
        } else {
            $this->_estableceError(0, 'Los archivos no son pareja');
        }

        return $this->_return;
    }

    /**
     * Summary of certificadoBase64
     * @param mixed $nombreCer
     * @return string
     */
    public function certificadoBase64($nombreCer = null)
    {
        if($nombreCer == null) {
            if($this->_cerPem != null) {
                $nombreCer = $this->_cerPem;
            } else {
                $nombreCer = $this->_path.'desconocido.ccg';
            }
        } else {
            $nombreCer = $this->_path.$nombreCer;
        }
        return base64_encode(implode(file($this->_path.$nombreCer)));
    }

    /**
     * Summary of selloGenerar
     * @param mixed $cadenaOriginal
     * @return bool|string|null
     */
    public function selloGenerar($cadenaOriginal = null)
    {
        if($cadenaOriginal === null) {
            return null;
        }
        return shell_exec('openssl dgst -sha256 -sign '.$this->_keyPem.' '.$cadenaOriginal.' 2>&1 | openssl enc -base64 -A 2>&1');
    }

    /**
     * Summary of selloPfxGenerar
     * @param mixed $cadenaOriginal
     * @return bool|string|null
     */
    public function selloPfxGenerar($cadenaOriginal = null, $pfx = null, $password = null)
    {
        $password = $password ?? $this->_password;

        $pfx = $pfx ?? $this->_pfx;

        if ($cadenaOriginal === null || empty($pfx) || empty($password)) {
            return "Error: Cadena original, PFX y contraseña son requeridos.";
        }

        $tempPfxPem = tempnam(sys_get_temp_dir(), 'temppfx');
        file_put_contents($tempPfxPem, base64_decode($pfx));

        $tempKeyPem = tempnam(sys_get_temp_dir(), 'tempkey');

        try {
            exec("openssl pkcs12 -in $tempPfxPem -nocerts -out $tempKeyPem -password pass:$password");
            $output = shell_exec("openssl dgst -sha256 -sign $tempKeyPem <<< \"$cadenaOriginal\" | openssl enc -base64 -A");
        } finally {
            unlink($tempPfxPem);
            unlink($tempKeyPem);
        }

        return $output;
    }

    /**
     * Summary of getDatosCertificado
     * @param mixed $nombreCerPem
     * @return array|bool|null
     */
    public function getDatosCertificado($nombreCerPem = null)
    {
        if($nombreCerPem === null) {
            return null;
        }
        return openssl_x509_parse(file_get_contents($nombreCerPem));
    }

    /**
     * Summary of getOwnerCertificado
     * @param mixed $nombreCerPem
     * @return mixed
     */
    public function getOwnerCertificado($nombreCerPem = null)
    {
        if ($nombreCerPem === null) {
            return '';
        }

        $certInfo = openssl_x509_parse(file_get_contents($nombreCerPem));

        if (isset($certInfo['subject']['name'])) {
            return $certInfo['subject']['name'];
        }

        return '';
    }

    /**
     * Summary of getRFC
     * @param mixed $nombreCerPem
     * @return string
     */
    public function getRFC($nombreCerPem = null)
    {
        if ($nombreCerPem === null) {
            return ''; // Opcional: Manejar el caso cuando no se proporciona el nombre del archivo
        }

        $certInfo = openssl_x509_parse(file_get_contents($nombreCerPem));

        if (isset($certInfo['subject']['x500UniqueIdentifier'])) {
            $rfc = explode('/', $certInfo['subject']['x500UniqueIdentifier'])[0];
            return trim((string)$rfc);
        }

        return '';
    }

    /**
     * Summary of getSerialNumber
     * @param mixed $nombreCerPem
     * @return string
     */
    public function getSerialNumber($nombreCerPem)
    {
        $salida = openssl_x509_parse(file_get_contents($nombreCerPem))['serialNumberHex'];
        $string = '';

        for ($i = 0; $i < strlen($salida) - 1; $i += 2) {
            $string .= chr(hexdec($salida[$i] . $salida[$i + 1]));
        }

        return $string;
    }


    /**
     * Summary of obtenerContenidoKeyPemDesdeBase64
     * @param mixed $llavePrivadaBase64
     * @param mixed $password
     * @throws \Exception
     * @return bool|string
     */
    public function obtenerContenidoKeyPemDesdeBase64($llavePrivadaBase64, $password)
    {
        $decodedKey = base64_decode($llavePrivadaBase64, true);
        if ($decodedKey === false) {
            throw new Exception("Error: La clave privada en base64 no es válida.");
        }

        $tempKey = tempnam(sys_get_temp_dir(), 'tempkey');
        file_put_contents($tempKey, $decodedKey);

        $tempkeyPem = tempnam(sys_get_temp_dir(), 'temppem');

        try {
            exec("openssl pkcs8 -inform DER -in $tempKey -passin pass:$password -out  $tempkeyPem");
            $contenidoKeyPem = file_get_contents($tempkeyPem);

            return $contenidoKeyPem;
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        } finally {
            unlink($tempkeyPem);
            unlink($tempKey);
        }
    }

    /**
     * Summary of obtenerContenidoCerPemDesdeBase64
     * @param mixed $certificadoBase64
     * @return string
     */
    public function obtenerContenidoCerPemDesdeBase64($certificadoBase64)
    {
        try {
            $tempCerDer = tempnam(sys_get_temp_dir(), 'tempcer');
            file_put_contents($tempCerDer, base64_decode($certificadoBase64));

            $tempCerPem = tempnam(sys_get_temp_dir(), 'tempcerpem');
            shell_exec('openssl x509 -inform DER -in ' . $tempCerDer . ' -out ' . $tempCerPem);

            unlink($tempCerDer);

            $contenidoCerPem = file_get_contents($tempCerPem);

            unlink($tempCerPem);

            $this->_cerPem = $contenidoCerPem;
            return $contenidoCerPem;
        } catch (Exception $e) {
            return "Excepción: " . $e->getMessage();
        }
    }

    /**
     * Summary of generaPFX
     * @param mixed $password
     * @param mixed $nombreCertificadoPem
     * @param mixed $nombreKeyPem
     * @return string
     */
    public function generaPFX($password, $certificadoBase64 = null, $keyBase64 = null)
    {
        try {

            $tempCertPemPath = tempnam(sys_get_temp_dir(), 'tempcert_') . '.cer.pem';
            $tempKeyPemPath = tempnam(sys_get_temp_dir(), 'tempkey_') . '.key.pem';
            $pfxPath = tempnam(sys_get_temp_dir(), 'temppfx_') . '.pfx';

            file_put_contents($tempCertPemPath, $certificadoBase64);
            file_put_contents($tempKeyPemPath, $keyBase64);

            shell_exec("openssl pkcs12 -export -out $pfxPath -inkey $tempKeyPemPath -in $tempCertPemPath -passout pass:$password");

            $pfxContent = file_get_contents($pfxPath);

            return base64_encode($pfxContent);
        } catch (Exception $e) {
            return "Excepción: " . $e->getMessage();
        } finally {
            if (!empty($tempCertPemPath) || !empty($tempKeyPemPath) || empty(!$pfxPath)) {
                unlink($tempCertPemPath);
                unlink($tempKeyPemPath);
                unlink($pfxPath);
            }
        }
    }

    /**
     * Summary of obtenerContenidoCerPemDesdeBase64
     * @param mixed $certificadoBase64
     * @return string|null
     */
    public function getPemRFC($certificadoBase64 = null)
    {
        $contenidoCerPem = $certificadoBase64 ?? $this->_cerPem;

        if($contenidoCerPem === null) {
            throw new Exception("No se ha podido determinar el contenido del certificado en formato PEM.");
        }

        $certInfo = openssl_x509_parse($contenidoCerPem);

        if (isset($certInfo['subject']['x500UniqueIdentifier'])) {
            $rfc = explode('/', $certInfo['subject']['x500UniqueIdentifier'])[0];
            return trim((string)$rfc);
        }

        return '';
    }

    /**
     * Summary of getPemSerialNumber
     * @param mixed $certificadoBase64
     * @throws \Exception
     * @return string
     */
    public function getPemSerialNumber($certificadoBase64 = null)
    {
        $contenidoCerPem = $certificadoBase64 ?? $this->_cerPem;

        if ($contenidoCerPem === null) {
            throw new Exception("No se ha podido determinar el contenido del certificado en formato PEM.");
        }

        $salida = openssl_x509_parse($contenidoCerPem)['serialNumberHex'];

        $string = '';
        for ($i = 0; $i < strlen($salida) - 1; $i += 2) {
            $string .= chr(hexdec($salida[$i] . $salida[$i + 1]));
        }

        return $string;
    }

    /**
     * Summary of getPemOwnerCertificado
     * @param mixed $certificadoBase64
     * @throws \Exception
     * @return mixed
     */
    public function getPemOwnerCertificado($certificadoBase64 = null)
    {
        $contenidoCerPem = $certificadoBase64 ?? $this->_cerPem;

        if ($contenidoCerPem === null) {
            throw new Exception("No se ha podido determinar el contenido del certificado en formato PEM.");
        }

        $certInfo = openssl_x509_parse($contenidoCerPem);

        if (isset($certInfo['subject']['name'])) {
            return $certInfo['subject']['name'];
        }

        return '';
    }

    /**
     * Summary of getPemFechaVigencia
     * @param mixed $certificadoBase64
     * @throws \Exception
     * @return array|string
     */
    public function getPemFechaVigencia($certificadoBase64 = null)
    {
        $contenidoCerPem = $certificadoBase64 ?? $this->_cerPem;

        if ($contenidoCerPem === null) {
            throw new Exception("No se ha podido determinar el contenido del certificado en formato PEM.");
        }

        $certInfo = openssl_x509_parse($contenidoCerPem);

        if (isset($certInfo['validTo_time_t'])) {
            $fechaUnix = $certInfo['validTo_time_t'];
            $fechaVigencia = date('Y-m-d H:i:s', $fechaUnix);

            return $fechaVigencia;
        }

        return '';
    }

    /**
     * Summary of getPemFechaInicio
     * @param mixed $certificadoBase64
     * @throws \Exception
     * @return string
     */
    public function getPemFechaInicio($certificadoBase64 = null)
    {
        $contenidoCerPem = $certificadoBase64 ?? $this->_cerPem;

        if ($contenidoCerPem === null) {
            throw new Exception("No se ha podido determinar el contenido del certificado en formato PEM.");
        }

        $certInfo = openssl_x509_parse($contenidoCerPem);

        if (isset($certInfo['validFrom_time_t'])) {
            $fechaUnix = $certInfo['validFrom_time_t'];
            $fechaInicio = date('Y-m-d H:i:s', $fechaUnix);

            return $fechaInicio;
        }

        return '';
    }

    public function selloPemGenerar($cadenaOriginal = null, $privateKeyBase64 = null, $password = null)
    {
        if ($cadenaOriginal === null) {
            return null;
        }

        $privateKey = base64_decode($privateKeyBase64 ?? $this->_keyPem);
        $password = $password ?? $this->_password;

        $privateKeyResource = openssl_pkey_get_private($privateKey, $password);

        if ($privateKeyResource === false) {
            return null;
        }
        $result = openssl_sign($cadenaOriginal, $selloDigital, $privateKeyResource, OPENSSL_ALGO_SHA256);

        if ($result === false) {
            return null;
        }

        return base64_encode($selloDigital);
    }

}
