<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $id_estudio = sqlValue($_POST["id_estudio"], "int");
 $id_usuario = sqlValue($_POST["id_usuario"], "int");
 
mysql_select_db($database_horizonte, $horizonte);
	$sql = "UPDATE historial_estudios SET quien_proceso = $id_usuario WHERE id_estudio = $id_estudio LIMIT 1 ";
	$update = mysql_query($sql, $horizonte);
	
	if (!$update) { echo $sql; }
	else {
		echo 1;
	}
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>