<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idUsuario = sqlValue($_POST["idUsuarioP"], "int");
 $clave = sqlValue($_POST["claveC"], "text");
 $nombre = sqlValue($_POST["nombreC"], "text");
 $descripcion = sqlValue($_POST["descripcionC"], "text");
 
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO convenios (clave_cv, convenio_cv, descripcion_cv, usuario_cv, fecha_cv)";
 $sql.= "VALUES ($clave, $nombre, $descripcion, $idUsuario, now())";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) {
 	echo $sql;
 }else{ 
	echo 'ok';
 }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>