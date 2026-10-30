<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $id = sqlValue($_POST["id"], "int");
 
 mysql_select_db($database_horizonte, $horizonte);
 $result = mysql_query("SELECT mensaje_mn FROM mensaje_nom35 WHERE id_mn = $id", $horizonte) or die (mysql_error());
 $row = mysql_fetch_row($result);

 //$datos = $row[0];

 //echo $datos;

 echo $row[0];
 
 //Cerrar conexión a la Base de Datos
mysql_close($horizonte);
?>