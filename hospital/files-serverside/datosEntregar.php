<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idVC = sqlValue($_POST["idVC"], "int");

	mysql_select_db($database_horizonte, $horizonte);
	$result = mysql_query("SELECT referencia_vc, id_paciente_vc from venta_conceptos where id_vc = $idVC ", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result);
	
	$idP = sqlValue($row[1], "int");
	
	mysql_select_db($database_horizonte, $horizonte);
	$result1 = mysql_query("SELECT nombre_p, apaterno_p, amaterno_p from pacientes where id_p = $idP ", $horizonte) or die (mysql_error());
 	$row1 = mysql_fetch_row($result1);
	
	$nombre = $row1[0].' '.$row1[1].' '.$row1[2];
	
	$datos = $nombre.';*-'.$row[0];
	
echo $datos;
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>