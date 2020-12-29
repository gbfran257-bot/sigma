<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	$id_s = sqlValue($_POST["id_s"], "text");
	$nombre = sqlValue($_POST["nombre"], "text");
 
	mysql_select_db($database_horizonte, $horizonte);
	$result = mysql_query("SELECT id_do, ext_do, que_es_do from documentos where nombre_do = $nombre and aleatorio_do = $id_s order by id_do desc ", $horizonte) or die (mysql_error());
	$row = mysql_fetch_row($result);
	
	echo $row[0].'*{'.$row[1].'*{'.$row[2];
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>