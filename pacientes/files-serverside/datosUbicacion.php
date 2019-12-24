<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	$idU = sqlValue($_POST["idU"], "int");
 
	mysql_select_db($database_horizonte, $horizonte);
	$result = mysql_query("SELECT X(GeomFromText(AsText(coordenadas_p))), Y(GeomFromText(AsText(coordenadas_p))) from pacientes where id_p = $idU ", $horizonte) or die (mysql_error());
	$row = mysql_fetch_row($result);
	
	echo $row[0].'{}*'.$row[1];
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>