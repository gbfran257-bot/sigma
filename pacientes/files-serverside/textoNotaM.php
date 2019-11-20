<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	$idF = sqlValue($_POST["idNM"], "int");

	mysql_select_db($database_horizonte, $horizonte);
	$result = mysql_query("SELECT formato_fo from formatos where id_fo = $idF ", $horizonte) or die (mysql_error());
	$row = mysql_fetch_row($result);
	
 echo $row[0];
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>