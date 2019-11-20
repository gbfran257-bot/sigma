<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idN = sqlValue($_POST["idN"], "int");
  
 	mysql_select_db($database_horizonte, $horizonte);
 	$result = mysql_query("SELECT nombre_fo, formato_fo, id_area_fo from formatos where id_fo = $idN ", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result);
			 
 	$datos = $row[0]."*}".$row[1]."*}".$row[2];

echo $datos;
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>