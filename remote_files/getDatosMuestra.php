<?php
require("../Connections/horizonte.php");
require("../funciones/php/values.php");

 $id_mu = sqlValue($_POST["id_mu"], "int");
 
 mysql_select_db($database_horizonte, $horizonte);
 $result = mysql_query("SELECT muestra_mu, id_condicion_mu FROM muestras WHERE id_mu = $id_mu ", $horizonte) or die (mysql_error());
 $row = mysql_fetch_row($result);

 $datos = $row[0]."*}".$row[1];

 echo $datos;
 
 //Cerrar conexión a la Base de Datos
mysql_close($horizonte);
?>