<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	$idU = sqlValue($_POST["idU"], "int");
 
	mysql_select_db($database_horizonte, $horizonte);
	$result = mysql_query("SELECT X(GeomFromText(AsText(coordenadas_su))), Y(GeomFromText(AsText(coordenadas_su))) from seguros where id_su = $idU ", $horizonte) or die (mysql_error());
	$row = mysql_fetch_row($result);
	
	echo $row[0].'{}*'.$row[1];
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>