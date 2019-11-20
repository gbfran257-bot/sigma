<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $idUsuario = sqlValue($_POST["idUsuarioNM"], "int");
 $nombre = sqlValue($_POST["nombreC"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 $descripcion = sqlValue($_POST["descripcionC"], "text");
 $tipo = sqlValue($_POST["tipoC"], "int");

 mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO valores_referencia(usuario_reg_vr, valor_referencia_vr, fecha_reg_vr, descripcion_vr, tipo_vr)";
 $sql.= "VALUES ($idUsuario, $nombre, $now, $descripcion, $tipo)";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) {
 	echo $sql;
 }else{ 
	echo 1;
 }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>