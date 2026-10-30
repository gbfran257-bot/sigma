<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $id = sqlValue($_POST["id_m"], "int");
 
 mysql_select_db($database_horizonte, $horizonte);
 $result = mysql_query("SELECT * from metodos where id_me = $id ", $horizonte) or die (mysql_error());
 $row = mysql_fetch_row($result);

 $datos = $row[0].'*}'. $row[1].'*}'. $row[2];

 echo $datos;
 
 //Cerrar conexión a la Base de Datos
mysql_close($horizonte);
?>