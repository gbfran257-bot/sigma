<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $idN = sqlValue($_POST["idN"], "int");
  
 	mysql_select_db($database_horizonte, $horizonte);
 	$result = mysql_query("SELECT no_ca, ubicacion_ca, area_ca, descripcion_ca from camas where id_ca = $idN ", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result);
			 
 	$datos = $row[0]."*}".$row[1]."*}".$row[2]."*}".$row[3];

echo $datos;
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>