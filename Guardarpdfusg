<?php
/* Guarda el PDF del informe de ultrasonido que genera el navegador (html2pdf.js) y devuelve su enlace.
   Ubicación: imagen/files-serverside/guardarPdfUSG.php
   Respuesta:  OK|https://tu-dominio/sigma/imagen/pdf_compartidos/usg_123_abc....pdf   o   ERROR: mensaje
   Los PDFs se guardan en imagen/pdf_compartidos/ con nombre aleatorio (no adivinable) y se borran a los 15 días. */
include_once '../../recursos/session.php';   // solo usuarios con sesión pueden subir PDFs
header('Content-Type: text/plain; charset=utf-8');

$maxMB   = 25;     // tamaño máximo del PDF
$diasVida = 15;    // días que se conserva el PDF antes de borrarse

if(!isset($_FILES['pdf'])){
	echo 'ERROR: no llegó el PDF (revisa post_max_size y upload_max_filesize en php.ini)'; exit;
}
if($_FILES['pdf']['error'] !== UPLOAD_ERR_OK){
	echo 'ERROR: falló la subida del PDF (código '.$_FILES['pdf']['error'].'; 1 y 2 = excede upload_max_filesize/post_max_size en php.ini)'; exit;
}
if($_FILES['pdf']['size'] > $maxMB*1024*1024){ echo 'ERROR: el PDF pesa más de '.$maxMB.' MB'; exit; }

// debe ser realmente un PDF
$fh = fopen($_FILES['pdf']['tmp_name'], 'rb'); $cab = fread($fh, 5); fclose($fh);
if($cab !== '%PDF-'){ echo 'ERROR: el archivo recibido no es un PDF'; exit; }

$idVC = isset($_POST['idVC']) ? intval($_POST['idVC']) : 0;

// carpeta de destino (sin listado de archivos)
$dir = dirname(dirname(__FILE__)).'/pdf_compartidos/';
if(!is_dir($dir)){
	if(!@mkdir($dir, 0755, true)){ echo 'ERROR: no se pudo crear la carpeta imagen/pdf_compartidos (revisa permisos)'; exit; }
}
if(!file_exists($dir.'.htaccess')){ @file_put_contents($dir.'.htaccess', "Options -Indexes\n"); }
if(!file_exists($dir.'index.html')){ @file_put_contents($dir.'index.html', ''); }

// limpieza de PDFs viejos
$files = glob($dir.'usg_*.pdf');
if($files){ foreach($files as $f){ if(filemtime($f) < time() - $diasVida*86400){ @unlink($f); } } }

// nombre aleatorio e imposible de adivinar
if(function_exists('openssl_random_pseudo_bytes')){ $rnd = bin2hex(openssl_random_pseudo_bytes(16)); }
else{ $rnd = md5(uniqid(mt_rand(), true)).md5(microtime()); }
$nombre = 'usg_'.$idVC.'_'.$rnd.'.pdf';

if(!move_uploaded_file($_FILES['pdf']['tmp_name'], $dir.$nombre)){
	echo 'ERROR: no se pudo guardar el PDF en el servidor (revisa permisos de imagen/pdf_compartidos)'; exit;
}

// enlace absoluto: esquema + host + carpeta de la aplicación (/sigma, /sigmacadit, etc.)
$https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
      || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) == 'https');
$base  = rtrim(dirname(dirname(dirname($_SERVER['SCRIPT_NAME']))), '/');
echo 'OK|'.($https ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].$base.'/imagen/pdf_compartidos/'.$nombre;
?>