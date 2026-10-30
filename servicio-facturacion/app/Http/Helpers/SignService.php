<?php

namespace App\Http\Helpers;

use Exception;

class SignService {
    public static function ObtenerSello($params) {
        self::checkOpenssl();
        
        $requiredParams = ['cadenaOriginal', 'archivoCerPem', 'archivoKeyPem'];
        foreach ($requiredParams as $param) {
            if (!isset($params[$param])) {
                throw new Exception("Se debe especificar una $param");
            }
        }
        
        $cadenaOriginal = self::getFileContent($params['cadenaOriginal']);
        $archivoCerPem = $params['archivoCerPem'];
        $archivoKeyPem = $params['archivoKeyPem'];
        
        self::existsFile($cadenaOriginal);
        self::existsFile($archivoCerPem);
        self::existsFile($archivoKeyPem);
        
        $pkeyid = openssl_get_privatekey(self::getFileContent($archivoKeyPem));
        openssl_sign($cadenaOriginal, $crypttext, $pkeyid, OPENSSL_ALGO_SHA256);
        
        $sello = base64_encode($crypttext);
        
        if (!self::verifySeal($cadenaOriginal, $crypttext, $archivoCerPem)) {
            throw new Exception('Ocurrió un error al generar el sello.');
        }
        
        return json_decode(json_encode(['status' => 'success', 'sello' => $sello]));
    }
    
    private static function verifySeal($cadenaOriginal, $encryptData, $cerPem) {
        $pubkeyid = openssl_pkey_get_public(self::getFileContent($cerPem));
        $ok = openssl_verify($cadenaOriginal, $encryptData, $pubkeyid, OPENSSL_ALGO_SHA256);
        openssl_free_key($pubkeyid);
        return $ok == 1;
    }
    
    private static function getFileContent($file) {
        if (!file_exists($file)) {
            throw new Exception("El archivo $file no existe");
        }
        return file_get_contents($file);
    }
    
    private static function checkOpenssl() {
        if (!extension_loaded('openssl')) {
            throw new Exception('No se tiene openssl instalado');
        }
    }
    
    private static function existsFile($file) {
        if (!file_exists($file)) {
            throw new Exception("El archivo $file no existe");
        }
    }
}