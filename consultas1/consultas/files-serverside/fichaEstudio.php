<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $idE = sqlValue($_POST["idP"], "int"); 
 
 	mysql_select_db($database_horizonte, $horizonte);
 	$result = mysql_query("SELECT clave_est, nombre_est, precio_est, precio_maquila_est, depto_est, area_est, formato from estudios where id_est = $idE ", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result);
			 
 	$datos = $row[0]."*}".$row[1]."*}".$row[2]."*}".$row[3]."*}".$row[4]."*}".$row[5]."*}".$row[6];

echo $datos;
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>