<?php
require("../Connections/horizonte.php");
require("../funciones/php/values.php");

 $id_um = sqlValue($_POST["id_um"], "int");
 
 mysql_select_db($database_horizonte, $horizonte);
 $result = mysql_query("SELECT unidad_un, abreviacion_un from unidades where id_un = $id_um ", $horizonte) or die (mysql_error());
 $row = mysql_fetch_row($result);

 $datos = $row[0]."*}".$row[1];

 echo $datos;
 
 //Cerrar conexión a la Base de Datos
mysql_close($horizonte);
?>