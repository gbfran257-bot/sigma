<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	$aleatorio = sqlValue($_POST["aleatorioM"], "text");
	
	mysql_select_db($database_horizonte, $horizonte);
	$result = mysql_query("SELECT otras_indicaciones from venta_conceptos where no_temp_vc = $aleatorio ", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result);
	
	echo $row[0];
 	//Cerrar conexión a la Base de Datos
 	mysql_close($horizonte);
?>