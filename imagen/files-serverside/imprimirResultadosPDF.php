<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$idEvc = sqlValue($_GET["idE"], "int"); $i = 0; $f = 0; $idU = sqlValue($_GET["idU"], "int"); $filillas = 0;

	mysql_select_db($database_horizonte, $horizonte); 
 	$result = mysql_query("SELECT interpretacion_vc from venta_conceptos where id_vc = $idEvc", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result);
  
$tabla = sqlValue($row[0], "text");

 mysql_select_db($database_horizonte, $horizonte);
 $sqlX = "UPDATE usuarios SET variable_temporal_u = $tabla where id_u = $idU limit 1";
 $updateX = mysql_query($sqlX, $horizonte) or die (mysql_error());
	
 if(!$updateX){ echo $sqlX; }else{ echo $tabla; }
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>