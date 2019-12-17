<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idE = sqlValue($_POST["id_rl"], "int");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 
	mysql_select_db($database_horizonte, $horizonte);
 	$sql = "UPDATE resultados_laboratorio SET boleano_rl = 0 where id_rl = $idE limit 1 ";
 	$update = mysql_query($sql, $horizonte);
	
	if (!$update) { echo $sql; }else { echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>