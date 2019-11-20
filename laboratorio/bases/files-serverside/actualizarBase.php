<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $idUsuario = sqlValue($_POST["idUsuarioNM"], "int");
 $idEQ = sqlValue($_GET["idUM"], "int");
 $modelo = sqlValue($_POST["modeloE"], "text");
 $marca = sqlValue($_POST["marcaE"], "text");
 $descripcion = sqlValue($_POST["descripcionE"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");

 mysql_select_db($database_horizonte, $horizonte);
 $sql = "UPDATE catalogo_equipos set modelo_eq = $modelo, marca_eq = $marca, descripcion_eq = $descripcion, usuario_eq = $idUsuario, fecha_eq = $now where id_eq = $idEQ limit 1";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) {
 	echo $sql;
 }else{ 
	echo 1;
 }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>