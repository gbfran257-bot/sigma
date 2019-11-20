<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $aleatorio = sqlValue($_POST["aleatorio"], "text");

	mysql_select_db($database_horizonte, $horizonte);
 	$result1 = mysql_query("SELECT id_paciente_vc, DATE_FORMAT(fecha_venta_vc,'%d/%c/%Y') from venta_conceptos where no_temp_vc = $aleatorio limit 1 ", $horizonte) or die (mysql_error());
 	$row1 = mysql_fetch_row($result1); $idP = sqlValue($row1[0], "int");
 	
	mysql_select_db($database_horizonte, $horizonte);
 	$result = mysql_query("SELECT nombre_p, apaterno_p, amaterno_p from pacientes where id_p = $idP ", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result);
	
	$nombre = $row[0]." ".$row[1]." ".$row[2];
	
	echo $nombre.";}".$row1[1];

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>