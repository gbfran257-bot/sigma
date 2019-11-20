<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $idUsuario = sqlValue($_POST["idUsuarioNMu"], "int");
 $id = sqlValue($_GET["idMu"], "int");
 $muestra = sqlValue($_POST["nombreM"], "text");
 $condicion = sqlValue($_POST["condicionM"], "int");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");

 mysql_select_db($database_horizonte, $horizonte);
 $sql = "UPDATE muestras set muestra_mu = $muestra, id_condicion_mu = $condicion, usuario_reg_mu = $idUsuario, fecha_reg_mu = $now where id_mu = $id limit 1";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) {
 	echo $sql;
 }else{ 
	echo 1;
 }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>