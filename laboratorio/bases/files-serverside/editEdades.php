<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $idUsuario = sqlValue($_POST["idUsuarioUE"], "int");
 $para = sqlValue($_POST["tipoEdad"], "text");
 $id = sqlValue($_POST["idAVR"], "int");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 $edadI = sqlValue($_POST["edadI"], "int");
 $edadF = sqlValue($_POST["edadF"], "int");
 $tipo_edad = sqlValue($_POST["tipo_edadR"], "text");
  
 $sql = "UPDATE asignar_valor_referencia SET para_edades = $para, rango_edad1 = $edadI, rango_edad2 = $edadF, tipo_edad = $tipo_edad where id_avr = $id limit 1";

mysql_select_db($database_horizonte, $horizonte);
$insertar = mysql_query($sql, $horizonte);
 	
if (!$insertar) { echo $sql; }else { echo 1; }
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>