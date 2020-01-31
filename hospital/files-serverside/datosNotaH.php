<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	$id_n = sqlValue($_POST["id_n"], "int");

	mysql_select_db($database_horizonte, $horizonte);
	$result = mysql_query("SELECT nota_nh from notas_de_hospital where id_nh = $id_n limit 1 ", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result);
	
	echo $row[0];
 	//Cerrar conexión a la Base de Datos
 	mysql_close($horizonte);
?>