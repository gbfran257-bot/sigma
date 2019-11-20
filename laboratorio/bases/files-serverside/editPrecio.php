<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $precio = sqlValue($_POST["precioC"], "double");
 $id = sqlValue($_POST["idAC"], "int");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
  
 $sql = "UPDATE asignar_consumibles SET precio_ac = $precio where id_ac = $id limit 1";

mysql_select_db($database_horizonte, $horizonte);
$insertar = mysql_query($sql, $horizonte);
 	
if (!$insertar) { echo $sql; }else { echo 1; }
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>