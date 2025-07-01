<?php
session_start();
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $refe = sqlValue($_POST["refe"], "text");
 $motivo = sqlValue(mb_strtoupper($_POST["motivo"]), "text");

 //revisamos si la orden de venta a eliminar tiene conceptos en un estado de proceso o superior.
 mysql_select_db($database_horizonte, $horizonte);
 $qry_busqueda_estatus = mysql_query("SELECT COUNT(*) FROM venta_conceptos WHERE estatus_vc > 1 AND referencia_vc = $refe", $horizonte) or die (mysql_error());
 $estatus_encontrados = mysql_fetch_row($qry_busqueda_estatus);

 if($estatus_encontrados[0] == 0){

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
	}
	echo 1;

 }else{
	echo 2;
 }
 




 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>
