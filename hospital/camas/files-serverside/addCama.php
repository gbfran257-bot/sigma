<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $idUsuario = sqlValue($_POST["idusuarioNM"], "int");
 $numero = sqlValue($_POST["numeroCama"], "text");
 $ubicacion = sqlValue($_POST["ubicacionCama"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 $area = sqlValue($_POST["area_cama"], "int");
 $descripcion = sqlValue($_POST["miDiagnostico"], "text");
 
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO camas(no_ca, ubicacion_ca, usuario_ca, fecha_ca, area_ca, descripcion_ca)";
 $sql.= "VALUES ($numero, $ubicacion, $idUsuario, $now, $area, $descripcion)";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) { echo $sql; }else{ echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>