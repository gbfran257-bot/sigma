<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	$idTo = sqlValue($_POST["id"], "int");
 
	mysql_select_db($database_horizonte, $horizonte);
	$result = mysql_query("SELECT concepto_to, id_area_to, precio_to, precio_urgencia_to, precio_m, precio_mu, precio_h from conceptos where id_to = $idTo ", $horizonte) or die (mysql_error());
	$row = mysql_fetch_row($result);
	
	mysql_select_db($database_horizonte, $horizonte);
	$resultN = mysql_query("SELECT count(id_vc) from venta_conceptos where id_concepto_es = $idTo", $horizonte) or die (mysql_error());
	$rowN = mysql_fetch_row($resultN);
	
	echo $row[0].'{}*'.$row[1].'{}*'.$row[2].'{}*'.$row[3].'{}*'.$row[4].'{}*'.$row[5].'{}*'.$rowN[0].'{}*'.$row[6];
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>