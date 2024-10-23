<?php
session_start();
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $refe = sqlValue($_POST["refe"], "text");
 $motivo = sqlValue(mb_strtoupper($_POST["motivo"]), "text");
 
 mysql_select_db($database_horizonte, $horizonte); 

$q = "select * from venta_conceptos where referencia_vc = $refe";
$f = mysql_query($q, $horizonte);
while($r = mysql_fetch_assoc($f)){
	$bk = "insert into venta_conceptos_del (";
	$values = "";
	foreach($r as $i=>$v){
		$bk .= $i.", ";
		$values .= sqlValue($v, "text").", ";
	}
	$bk .= "borron, tiempo) values (".$values.sqlValue($_SESSION['id'], "int").", now())";
	$res1 = mysql_query($bk, $horizonte);
	if (!$res1) {
		die('Invalid: ' . mysql_error());
	}else{
		mysql_select_db($database_horizonte, $horizonte); 
		$contador_vc = mysql_query("select count(*) from venta_conceptos where referencia_vc = $refe", $horizonte) or die (mysql_error());
		$cont_vc = mysql_fetch_row($contador_vc);

		mysql_select_db($database_horizonte, $horizonte); 
		$consulta_update3 = "update venta_conceptos set estatus_vc = 11 where referencia_vc = $refe LIMIT " . $cont_vc[0];
		$ejecutar_consulta3 = mysql_query($consulta_update3, $horizonte);
	}
	
}
	
$q = "select * from pagos_ov where referencia_pag = $refe";
$f = mysql_query($q, $horizonte);
while($r = mysql_fetch_assoc($f)){
	$bk = "insert into pagos_ov_del (";
	$values = "";
	foreach($r as $i=>$v){
		$bk .= $i.", ";
		$values .= sqlValue($v, "text").", ";
	}
	$bk .= "borron, tiempo) values (".$values.sqlValue($_SESSION['id'], "int").", now())";
	$res2 = mysql_query($bk, $horizonte);
	if (!$res2) {
		die('Invalid query: ' . mysql_error());
	}else{
		mysql_select_db($database_horizonte, $horizonte); 
		$contador_pagos = mysql_query("select count(*) from pagos_ov where referencia_pag = $refe", $horizonte) or die (mysql_error());
		$cont_pag = mysql_fetch_row($contador_pagos);

		mysql_select_db($database_horizonte, $horizonte); 
		$consulta_update2 = "update pagos_ov set estatus_pag = 11 where referencia_pag = $refe LIMIT " . $cont_pag[0];
		$ejecutar_consulta2 = mysql_query($consulta_update2, $horizonte);
	}
}
	
$q = "select * from orden_venta where referencia_ov = $refe";
$f = mysql_query($q, $horizonte);
$r = mysql_fetch_assoc($f);
$bk = "insert into orden_venta_del (";
$values = "";
foreach($r as $i=>$v){
	$bk .= $i.", ";
	$values .= sqlValue($v, "text").", ";
}
$bk .= "borron, tiempo, motivo_del, estatus) values (".$values.sqlValue($_SESSION['id'], "int").", now(), $motivo, 0)";
$res3 = mysql_query($bk, $horizonte);
if (!$res3) {
	die('Invalid query: ' . mysql_error());
}else{
	mysql_select_db($database_horizonte, $horizonte); 
	$consulta_update = "update orden_venta set estatus_ov = 11 where referencia_ov = $refe LIMIT 1";
	$ejecutar_consulta = mysql_query($consulta_update, $horizonte);
}
echo 1;



 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>
