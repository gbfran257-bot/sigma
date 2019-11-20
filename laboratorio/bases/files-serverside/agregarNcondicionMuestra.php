<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $idUsuario = sqlValue($_POST["id_u"], "int");
 $nombre = sqlValue(mb_strtoupper($_POST["nombre"]), "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");

 mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO condiciones (condicion_co, usuario_reg_co, fecha_co)";
 $sql.= "VALUES ($nombre, $idUsuario, $now)";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update){ echo $sql; }else{ echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>