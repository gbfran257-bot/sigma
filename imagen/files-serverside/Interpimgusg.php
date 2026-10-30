<?php
/* Guarda / lee el contenido de la pestaña "INTERPRETACIÓN EN IMAGEN" de un ultrasonido.
   Ubicación: imagen/files-serverside/interpImgUSG.php
   POST accion=guardar  idE=<id_vc>  dx=<html>   ->  OK|   o   ERROR: ...
   POST accion=leer     idE=<id_vc>               ->  OK|<html guardado>   (vacío si no hay nada)
   Guarda en venta_conceptos.interpretacion_img_vc (la columna se crea sola la primera vez). */
include_once '../../recursos/session.php';
require("../../Connections/horizonte.php");
header('Content-Type: text/plain; charset=utf-8');

mysql_select_db($database_horizonte, $horizonte);
$idE    = isset($_POST['idE']) ? intval($_POST['idE']) : 0;
$accion = isset($_POST['accion']) ? $_POST['accion'] : '';
if($idE <= 0){ echo 'ERROR: falta el id del estudio'; exit; }

// crea la columna si todavía no existe
$rc = mysql_query("SHOW COLUMNS FROM venta_conceptos LIKE 'interpretacion_img_vc'", $horizonte);
if(!$rc){ echo 'ERROR: '.mysql_error(); exit; }
if(mysql_num_rows($rc) == 0){
	if(!mysql_query("ALTER TABLE venta_conceptos ADD COLUMN interpretacion_img_vc LONGTEXT NULL", $horizonte)){
		echo "ERROR: no se pudo crear la columna. Ejecuta en MySQL: ALTER TABLE venta_conceptos ADD COLUMN interpretacion_img_vc LONGTEXT NULL;  (".mysql_error().")"; exit;
	}
}

if($accion == 'guardar'){
	$dx = isset($_POST['dx']) ? $_POST['dx'] : '';
	if(function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()){ $dx = stripslashes($dx); }
	$dx = mysql_real_escape_string($dx, $horizonte);
	if(!mysql_query("UPDATE venta_conceptos SET interpretacion_img_vc = '$dx' WHERE id_vc = $idE LIMIT 1", $horizonte)){
		echo 'ERROR: '.mysql_error(); exit;
	}
	echo 'OK|';
}elseif($accion == 'leer'){
	$r = mysql_query("SELECT interpretacion_img_vc FROM venta_conceptos WHERE id_vc = $idE LIMIT 1", $horizonte);
	if(!$r){ echo 'ERROR: '.mysql_error(); exit; }
	$row = mysql_fetch_row($r);
	echo 'OK|'.($row ? $row[0] : '');
}else{
	echo 'ERROR: acción no válida';
}
?>