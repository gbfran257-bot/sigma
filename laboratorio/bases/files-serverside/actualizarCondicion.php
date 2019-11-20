<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $idUsuario = sqlValue($_POST["idUsuarioNI"], "int");
 $id = sqlValue($_GET["idCo"], "int");
 $condicion = sqlValue($_POST["nombreCM"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");

 mysql_select_db($database_horizonte, $horizonte);
 $sql = "UPDATE condiciones set condicion_co = $condicion, usuario_reg_co = $idUsuario, fecha_co = $now where id_co = $id limit 1";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) {
 	echo $sql;
 }else{ 
	echo 1;
 }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>