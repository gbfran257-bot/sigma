<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $id = sqlValue($_GET["idvr"], "int");
 $idUsuario = sqlValue($_POST["idUsuarioNM"], "int");
 $nombre = sqlValue($_POST["nombreC"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 $tipo = sqlValue($_POST["tipoC"], "int");
 $descripcion = sqlValue($_POST["descripcionC"], "text");

 mysql_select_db($database_horizonte, $horizonte);
 $sql = "UPDATE valores_referencia set usuario_reg_vr = $idUsuario, valor_referencia_vr = $nombre, fecha_reg_vr = $now, descripcion_vr = $descripcion, tipo_vr = $tipo where id_vr = $id limit 1";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) {
 	echo $sql;
 }else{ 
	echo 1;
 }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>