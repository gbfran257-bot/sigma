<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 $estatus = sqlValue($_POST["estatus"], "int");
 $id_eu = sqlValue($_POST["id_eu"], "int");
 $aleatorio = sqlValue($_POST["aleatorio"], "text");

 mysql_select_db($database_horizonte, $horizonte);
 $sql = "UPDATE sucursales_usuarios set primaria_su = 0 where aleatorio_su = $aleatorio";
 $update = mysql_query($sql, $horizonte);
	
 if (!$update) { 
 	echo 'Ocurrió un error inesperado :/'; 
 }else{ 
	mysql_select_db($database_horizonte, $horizonte);
 	$sql1 = "UPDATE sucursales_usuarios set primaria_su = 1 where aleatorio_su = $aleatorio and id_su = $id_eu limit 1";
 	$update1 = mysql_query($sql1, $horizonte);
	if (!$update1) { echo 'Ocurrió un error inesperado :/'; }else{ echo 1; }
 }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>