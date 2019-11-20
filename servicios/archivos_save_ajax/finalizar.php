<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idS = sqlValue($_POST["idS"], "int");
 $idU = sqlValue($_POST["idU"], "int");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 $input = sqlValue($_POST["input"], "text");
 
mysql_select_db($database_horizonte, $horizonte);
$sql = "UPDATE venta_conceptos SET estatus_vc = 5, usuarioEdo5_e = $idU, fechaEdo5_e = $now, interpretacion_vc = $input, salvado_vc = 1 where id_vc = $idS ";  
$update = mysql_query($sql, $horizonte);
	
if (!$update) { echo $sql; }else { echo 1; }
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>