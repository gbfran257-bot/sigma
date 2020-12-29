<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	$id_s = sqlValue($_POST["id_s"], "int");
	$que_es = sqlValue($_POST["que_es"], "text");
 	
	//Saber si hay encabezado
	mysql_select_db($database_horizonte, $horizonte);
	$result = mysql_query("SELECT count(id_do), id_do, ext_do from documentos where id_quien_do = $id_s and que_es_do = $que_es and nombre_do = 'ENCABEZADO' ", $horizonte) or die (mysql_error()); $row = mysql_fetch_row($result);
	
	//Saber si hay pie
	mysql_select_db($database_horizonte, $horizonte);
	$result1 = mysql_query("SELECT count(id_do), id_do, ext_do from documentos where id_quien_do = $id_s and que_es_do = $que_es and nombre_do = 'PIE' ", $horizonte) or die (mysql_error()); $row1 = mysql_fetch_row($result1);
	
	echo $row[0].'*{'.$row[1].'*{'.$row[2].'*{'.$row1[0].'*{'.$row1[1].'*{'.$row1[2];
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>