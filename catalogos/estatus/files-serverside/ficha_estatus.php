<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $id = sqlValue($_POST["id_um"], "int");
 
 mysql_select_db($database_horizonte, $horizonte);
 $result = mysql_query("SELECT estatus_est from estatus where id_est = $id ", $horizonte) or die (mysql_error());
 $row = mysql_fetch_row($result);

 $datos = $row[0];

 echo $datos;
 
 //Cerrar conexión a la Base de Datos
mysql_close($horizonte);
?>