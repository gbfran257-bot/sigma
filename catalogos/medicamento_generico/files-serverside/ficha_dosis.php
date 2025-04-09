<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

$id = sqlValue($_POST["id"], "int");

mysql_select_db($database_horizonte, $horizonte);
$result = mysql_query("SELECT descripcion_to from conceptos where id_to = $id LIMIT 1", $horizonte) or die (mysql_error());
$row = mysql_fetch_row($result);

echo $row[0];

//Cerrar conexión a la Base de Datos
mysql_close($horizonte);
?>