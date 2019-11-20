<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idP = sqlValue($_POST["idP"], "int");
 $idE = sqlValue($_POST["idC"], "int");
 
 if(isset($_POST["x"]) and $_POST["x"]==0){		
	mysql_select_db($database_horizonte, $horizonte);
	$result1 = mysql_query("SELECT id_vc from venta_conceptos where id_vc = $idE and temporal_vc = 0 ", $horizonte) or die (mysql_error());
 	$row1 = mysql_fetch_row($result1);
 }else{
	mysql_select_db($database_horizonte, $horizonte);
	$result = mysql_query("SELECT max(id_vc) from venta_conceptos where id_paciente_vc = $idP and tipo_concepto_vc = 4 and estatus_vc = 5 and id_vc not in ($idE) and area_vc = 29 and temporal_vc = 0 limit 1 ", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result); $ultimo = sqlValue($row[0], "int");
	
	mysql_select_db($database_horizonte, $horizonte);
	$result1 = mysql_query("SELECT id_vc from venta_conceptos where id_vc = $ultimo limit 1 ", $horizonte) or die (mysql_error());
 	$row1 = mysql_fetch_row($result1);
 }
			
echo $row1[0];
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>