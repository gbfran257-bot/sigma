<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $idUsuario = sqlValue($_POST["idUsuarioNC"], "int");
 $nombre = sqlValue($_POST["nombreC"], "text");
 $idArea = sqlValue($_POST["areaC"], "int");
 $precio = sqlValue($_POST["precioC"], "double");
 $precioU = sqlValue($_POST["precioCurgencia"], "double");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");

 mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO conceptos (usuario_to, concepto_to, id_area_to, precio_to, precio_urgencia_to, fecha_to, id_departamento_to, id_tipo_concepto_to)";
 $sql.= "VALUES ($idUsuario, $nombre, $idArea, $precio, $precioU, $now, 4, 1)";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) { echo $sql; }else{ echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>