<?php
session_start();
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $refe = sqlValue($_POST["refe"], "text");
 
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
	mysql_query($bk, $horizonte);
}

 $sql = "delete from venta_conceptos where referencia_vc = $refe";
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
 if (!$update){ echo $sql; }
 else{
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
		mysql_query($bk, $horizonte);
	}


	 $sql1 = "delete from pagos_ov where referencia_pag = $refe";
	 $update1 = mysql_query($sql1, $horizonte) or die (mysql_error());
	 
	 if (!$update1){ echo $sql1; }
 	 else{
 	 	$q = "select * from orden_venta where referencia_ov = $refe";
		$f = mysql_query($q, $horizonte);
		$r = mysql_fetch_assoc($f);
		$bk = "insert into orden_venta_del (";
		$values = "";
		foreach($r as $i=>$v){
			$bk .= $i.", ";
			$values .= sqlValue($v, "text").", ";
		}
		$bk .= "borron, tiempo) values (".$values.sqlValue($_SESSION['id'], "int").", now())";
		mysql_query($bk, $horizonte);

		 $sql2 = "delete from orden_venta where referencia_ov = $refe limit 1";
		 $update2 = mysql_query($sql2, $horizonte) or die (mysql_error());
		 
		 if (!$update2){ echo $sql2; }
 	 	else{
	 		echo 1;
		}
	 }
 }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>