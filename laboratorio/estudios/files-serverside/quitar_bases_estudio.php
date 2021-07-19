<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $id = sqlValue($_GET["idest"], "int");
 
 	mysql_select_db($database_horizonte, $horizonte); 
 	$sql = "delete from asignar_bases where id_estudio_ab = $id";
	$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) { echo $sql; }else{  echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>