<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $idUsuario = sqlValue($_POST["idUsuarioUM"], "int");
 $idUM = sqlValue($_GET["idUM"], "int");
 $nombre = sqlValue($_POST["nombreUM"], "text");
 $abreviacion = sqlValue($_POST["abreviacionUM"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");

 mysql_select_db($database_horizonte, $horizonte);
 $sql = "UPDATE unidades set unidad_un = $nombre, abreviacion_un = $abreviacion, usuario_un = $idUsuario, fecha_un = $now where  id_un = $idUM limit 1";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) {
 	echo $sql;
 }else{ 
	echo 1;
 }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>