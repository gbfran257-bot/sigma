<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $nombre = sqlValue($_POST["nombre_nmed"], "text");
 $idU = sqlValue($_POST["id_u_nmed"], "int");
 $clave = sqlValue($_POST["clave_nmed"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 $descripcion = sqlValue($_POST["descripcion_nmed"], "text");
 $dosis = sqlValue($_POST["dosis_nmed"], "text");
 $presentacion = sqlValue($_POST["presentacion_nmed"], "text");
	
 mysql_select_db($database_horizonte, $horizonte); 
$sql="INSERT INTO medicamentos(clave_med,nombre_generico_med,descripcion_med,cantidad_med, usuario_med, fecha_med) VALUES ($clave, $nombre, $descripcion, $dosis, $idU, $now)";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) { echo $sql; }else{  echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>