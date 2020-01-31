<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	$id_m = sqlValue($_POST["id_m"], "int");

	mysql_select_db($database_horizonte, $horizonte);
	$result = mysql_query("SELECT descripcion_to from conceptos where id_to = $id_m limit 1 ", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result);
	
	echo $row[0];
 	//Cerrar conexión a la Base de Datos
 	mysql_close($horizonte);
?>