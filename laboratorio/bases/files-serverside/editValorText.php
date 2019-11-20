<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $valor = sqlValue($_POST["valorText"], "text");
 $id = sqlValue($_POST["idAVR"], "int");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
  
 $sql = "UPDATE asignar_valor_referencia SET valor_texto = $valor where id_avr = $id limit 1";

mysql_select_db($database_horizonte, $horizonte);
$insertar = mysql_query($sql, $horizonte);
 	
if (!$insertar) { echo $sql; }else { echo 1; }
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>