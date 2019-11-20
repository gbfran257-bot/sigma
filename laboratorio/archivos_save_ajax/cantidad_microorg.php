<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $id_rl = sqlValue($_POST["id_rl"], "int");
 $valor = sqlValue($_POST["valor"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 
	mysql_select_db($database_horizonte, $horizonte);
 	$sql = "UPDATE resultados_laboratorio SET r_valor_texto = $valor where id_rl = $id_rl ";
 	$update = mysql_query($sql, $horizonte);
	
	if (!$update) { echo $sql; }else { echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>