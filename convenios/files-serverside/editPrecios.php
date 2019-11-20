<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $precio = sqlValue($_POST["precioB"], "double");
 $precioU = sqlValue($_POST["precioBu"], "double");
 $id = sqlValue($_POST["idAC"], "int");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
  
 $sql = "UPDATE asigna_conceptos_convenios SET precio_ac = $precio, precio_urgencia_ac = $precioU where id_ac = $id limit 1";

mysql_select_db($database_horizonte, $horizonte);
$insertar = mysql_query($sql, $horizonte);
 	
if (!$insertar) { echo $sql; }else { echo 1; }
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>