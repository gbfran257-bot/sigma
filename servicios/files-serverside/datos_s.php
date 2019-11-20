<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php"); //CONSIDERANDOLO CLINICAMENTE SANO

 	$idC = sqlValue($_POST["idC"], "int");
	
	mysql_select_db($database_horizonte, $horizonte);
	$result = mysql_query("SELECT interpretacion_vc from venta_conceptos where id_vc = $idC limit 1", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result);
	
	echo $row[0];
 	//Cerrar conexión a la Base de Datos
 	mysql_close($horizonte);
?>