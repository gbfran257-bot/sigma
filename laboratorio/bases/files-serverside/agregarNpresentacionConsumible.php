<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $idUsuario = sqlValue($_POST["id_u"], "int");
 $presentacion = sqlValue(mb_strtoupper($_POST["nombre"]), "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");

 mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO catalogo_presentaciones(presentacion_cp, usuario_cp, fecha_cp)";
 $sql.= "VALUES ($presentacion, $idUsuario, $now)";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update){ echo $sql; }else{ echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>