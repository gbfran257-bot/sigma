<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $valorN = sqlValue($_POST["valorN"], "double");
 $rangoI = sqlValue($_POST["rangoI"], "double");
 $rangoF = sqlValue($_POST["rangoF"], "double");
 $valorA = sqlValue($_POST["valorA"], "double");
 $id = sqlValue($_POST["idAVR"], "int");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 $sexo = sqlValue($_POST["sexo"], "text");
 $tipoEdad = sqlValue($_POST["tipoEdad"], "text");
 $tipo_edadR = sqlValue($_POST["tipo_edadR"], "text");
 $edadI = sqlValue($_POST["edadI"], "int");
 $edadF = sqlValue($_POST["edadF"], "int");
  
 $sql = "UPDATE asignar_valor_referencia SET valor_normal_nma_i = $valorN, valor_r1_moderado_i = $rangoI, valor_r2_moderado_i = $rangoF, valor_alto_nma_i = $valorA, para_sexo = $sexo, para_edades = $tipoEdad, rango_edad1 = $edadI, rango_edad2 = $edadF, tipo_edad = $tipo_edadR where id_avr = $id limit 1";

mysql_select_db($database_horizonte, $horizonte);
$insertar = mysql_query($sql, $horizonte);
 	
if (!$insertar) { echo $sql; }else { echo 1; }
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>