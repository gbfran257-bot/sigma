<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $idN = sqlValue($_POST["idEstudioE"], "int");
 $numero = sqlValue($_POST["numeroCama"], "int");
 $ubicacion = sqlValue($_POST["ubicacionCama"], "text");
 $area = sqlValue($_POST["area_cama"], "int");
 $descripcion = sqlValue($_POST["miDiagnostico"], "text");
 
 $sql = "UPDATE camas SET no_ca = $numero, ubicacion_ca = $ubicacion, area_ca = $area, descripcion_ca = $descripcion where id_ca = $idN limit 1";

mysql_select_db($database_horizonte, $horizonte);
$insertar = mysql_query($sql, $horizonte);
 	
if (!$insertar) { echo $sql; }else { echo 1; }
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>