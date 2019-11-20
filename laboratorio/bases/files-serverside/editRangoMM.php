<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $valor = sqlValue($_POST["valor"], "int");
 $variacion = sqlValue($_POST["variacion"], "int");
 $id = sqlValue($_POST["idAVR"], "int");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 $sexo = sqlValue($_POST["sexo"], "text");
 $tipoEdad = sqlValue($_POST["tipoEdad"], "text");
 $tipo_edadR = sqlValue($_POST["tipo_edadR"], "text");
 $edadI = sqlValue($_POST["edadI"], "int");
 $edadF = sqlValue($_POST["edadF"], "int");
  
 $sql = "UPDATE asignar_valor_referencia SET valor_estable_rmn = $valor, valor_variable_rmn = $variacion, para_sexo = $sexo, para_edades = $tipoEdad, rango_edad1 = $edadI, rango_edad2 = $edadF, tipo_edad = $tipo_edadR where id_avr = $id limit 1";

mysql_select_db($database_horizonte, $horizonte);
$insertar = mysql_query($sql, $horizonte);
 	
if (!$insertar) { echo $sql; }else { echo 1; }
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>