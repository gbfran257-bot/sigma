<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $noTemp = sqlValue($_POST["noTemp"], "text");
 
 	mysql_select_db($database_horizonte, $horizonte); 
 	$sql = "delete from venta_conceptos where tipo_concepto_vc = 1 and no_temp_vc = $noTemp and temporal_vc = 1 limit 1";
	$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) { echo $sql; }else{  echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>