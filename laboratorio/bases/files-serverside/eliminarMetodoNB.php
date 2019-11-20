<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $idMetodo = sqlValue($_POST["idMetodo"], "int");
 
 	mysql_select_db($database_horizonte, $horizonte); 
 	$sql = "delete from asignar_metodo where id_ame = $idMetodo limit 1";
	$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) { echo $sql; }else{  echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>