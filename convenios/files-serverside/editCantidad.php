<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $cantidad = sqlValue($_POST["cantidadC"], "int");
 $id = sqlValue($_POST["idAC"], "int");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 
 if($_POST["cantidadC"]==100){
 	$sql = "UPDATE asigna_conceptos_convenios SET infinito_ac = 1 where id_ac = $id limit 1";
 }else{
 	$sql = "UPDATE asigna_conceptos_convenios SET infinito_ac = 0, cantidad_ac = $cantidad where id_ac = $id limit 1";
 }

mysql_select_db($database_horizonte, $horizonte);
$insertar = mysql_query($sql, $horizonte);
 	
if (!$insertar) { echo $sql; }else { echo 1; }
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>