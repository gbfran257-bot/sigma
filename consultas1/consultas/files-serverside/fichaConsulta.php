<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $idC = sqlValue($_POST["idC"], "int"); 
 
 	mysql_select_db($database_horizonte, $horizonte);
 	$result = mysql_query("SELECT concepto_to, id_area_to, precio_to, precio_urgencia_to, precio1_to, precio1_urgencia_to, precio_membrecia_to, precio_membrecia1 from conceptos where id_to = $idC ", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result);
			 
 	$datos = $row[0]."*}".$row[1]."*}".$row[2]."*}".$row[3]."*}".$row[4]."*}".$row[5]."*}".$row[6]."*}".$row[7];

echo $datos;
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>