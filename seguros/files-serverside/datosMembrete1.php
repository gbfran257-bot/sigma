<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	$id_s = sqlValue($_POST["id_s"], "text");
	$nombre = sqlValue($_POST["nombre"], "text");
	
	mysql_select_db($database_horizonte, $horizonte);
	$result1 = mysql_query("select count(id_do) from documentos where que_es_do = $nombre and aleatorio_do = $id_s", $horizonte) or die (mysql_error());
	$row1 = mysql_fetch_row($result1);
 
	mysql_select_db($database_horizonte, $horizonte);
	$result = mysql_query("SELECT id_do, ext_do, count(id_do) from documentos where que_es_do = $nombre and aleatorio_do = $id_s and nombre_do = 'ENCABEZADO'", $horizonte) or die (mysql_error());
	$row = mysql_fetch_row($result);
	
	mysql_select_db($database_horizonte, $horizonte);
	$result2 = mysql_query("SELECT id_do, ext_do, count(id_do) from documentos where que_es_do = $nombre and aleatorio_do = $id_s and nombre_do = 'PIE'", $horizonte) or die (mysql_error());
	$row2 = mysql_fetch_row($result2);
	
	echo $row[0].'*{'.$row[1].'*{'.$row1[0].'*{'.$row2[0].'*{'.$row2[1];
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>