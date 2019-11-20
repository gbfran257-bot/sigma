<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $idUsuario = sqlValue($_POST["idUsuarioNI"], "int");
 $id = sqlValue($_GET["idPr"], "int");
 $presentacion = sqlValue($_POST["presentacionC"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");

 mysql_select_db($database_horizonte, $horizonte);
 $sql = "UPDATE catalogo_presentaciones set presentacion_cp = $presentacion, usuario_cp = $idUsuario, fecha_cp = $now where id_cp = $id limit 1";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) {
 	echo $sql;
 }else{ 
	echo 1;
 }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>