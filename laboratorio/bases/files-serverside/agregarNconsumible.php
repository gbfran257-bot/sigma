<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $idUsuario = sqlValue($_POST["id_u"], "int");
 $nombre = sqlValue(mb_strtoupper($_POST["nombre"]), "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 $descripcion = sqlValue(mb_strtoupper($_POST["descripcion"]), "text");
 $tipo = sqlValue($_POST["tipo"], "int");
 $unidad = sqlValue($_POST["unidad"], "int");
 $presentacion = sqlValue($_POST["presentacion"], "int");

 mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO inventario(usuario_i, item_i, fecha_i, descripcion_i, id_tipo_i, id_unidad_i, id_presentacion_i)";
 $sql.= "VALUES ($idUsuario, $nombre, $now, $descripcion, $tipo, $unidad, $presentacion)";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update){echo $sql; }else{ echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>