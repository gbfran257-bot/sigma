<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	$idNM = sqlValue($_POST["idNM"], "int");

	mysql_select_db($database_horizonte, $horizonte);
	$result = mysql_query("SELECT nota_nm from notas_medicas where id_nm = $idNM ", $horizonte) or die (mysql_error());
	$row = mysql_fetch_row($result);
	
 echo $row[0];
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>