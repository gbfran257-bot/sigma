<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $id = sqlValue($_GET["idCo"], "int");
 $idUsuario = sqlValue($_POST["idUsuarioNM"], "int");
 $nombre = sqlValue($_POST["nombreC"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 $descripcion = sqlValue($_POST["descripcionC"], "text");
 $tipo = sqlValue($_POST["id_tipoCosumible"], "int");
 $unidad = sqlValue($_POST["id_umBasex"], "int");
 $presentacion = sqlValue($_POST["id_presentacionCosumible"], "int");

 mysql_select_db($database_horizonte, $horizonte);
 $sql = "UPDATE inventario set usuario_i = $idUsuario, item_i = $nombre, fecha_i = $now, descripcion_i = $descripcion, id_tipo_i = $tipo, id_unidad_i = $unidad, id_presentacion_i = $presentacion where id_i = $id limit 1";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) {
 	echo $sql;
 }else{ 
	echo 1;
 }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>