<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $id = sqlValue($_POST["id"], "int");

$result1 = mysql_query("SELECT concat(nombre_u,' ',apaterno_u) from usuarios where id_u = $id limit 1; ", $horizonte) or die (mysql_error());
$row1 = mysql_fetch_row($result1);

echo $row1[0];

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>