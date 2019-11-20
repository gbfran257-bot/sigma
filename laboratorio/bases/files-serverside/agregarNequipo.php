<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $idUsuario = sqlValue($_POST["id_u"], "int");
 $modelo = sqlValue(mb_strtoupper($_POST["nombre"]), "text");
 $marca = sqlValue(mb_strtoupper($_POST["marca"]), "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");

 mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO catalogo_equipos (usuario_eq, modelo_eq, marca_eq, fecha_eq)";
 $sql.= "VALUES ($idUsuario, $modelo, $marca, $now)";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if(!$update){ echo $sql; }else{ echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>