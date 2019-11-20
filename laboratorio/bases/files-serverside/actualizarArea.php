<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $idUsuario = sqlValue($_POST["idUsuarioNA"], "int");
 $id = sqlValue($_GET["idAre"], "int");
 $area = sqlValue($_POST["areaE1"], "text");
 $clave = sqlValue($_POST["claveE1"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");

 mysql_select_db($database_horizonte, $horizonte);
 $sql = "UPDATE areas set nombre_a = $area, usuario_a = $idUsuario, fecha_a = $now, clave_a = $clave where id_a = $id limit 1";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) {
 	echo $sql;
 }else{ 
	echo 1;
 }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>