<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $idUsuario = sqlValue($_POST["id_u"], "int");
 $nombre = sqlValue(mb_strtoupper($_POST["nombre"]), "text");
 $abreviacion = sqlValue($_POST["abreviacion"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");

 mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO unidades (unidad_un, abreviacion_un, usuario_un, fecha_un)";
 $sql.= "VALUES ($nombre, $abreviacion, $idUsuario, $now)";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if(!$update){ echo $sql; }else{ echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>