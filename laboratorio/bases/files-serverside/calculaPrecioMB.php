<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $idC = sqlValue($_POST["idC"], "int");
 
 	mysql_select_db($database_horizonte, $horizonte);
 	$result = mysql_query("SELECT aleatorio_ac from asignar_consumibles where id_ac = $idC ", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result); $aleatorio = sqlValue($row[0], "text");
	
	mysql_select_db($database_horizonte, $horizonte);
 	$result1 = mysql_query("SELECT SUM(precio_ac*cantidad_ac) from asignar_consumibles where aleatorio_ac = $aleatorio ", $horizonte) or die (mysql_error());
 	$row1 = mysql_fetch_row($result1);
			 
 	$datos = $row1[0];

echo $datos;
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>