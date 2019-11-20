<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	$aleatorio = sqlValue($_POST["aleatorio"], "text");
 
	mysql_select_db($database_horizonte, $horizonte);
	$result = mysql_query("SELECT id_do from documentos where nombre_do = $aleatorio and que_es_do = 'FOTO' ", $horizonte) or die (mysql_error());
	$row = mysql_fetch_row($result);
	
	echo $row[0];
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>