<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$id_dph = sqlValue($_POST["id_dph"],"int");
 
mysql_select_db($database_horizonte, $horizonte);
$consulta = mysql_query("SELECT * FROM datos_previos_hospitalizacion WHERE id_dph = $id_dph", $horizonte) or die (mysql_error());
$datos = mysql_fetch_row($consulta);

echo $datos[0].'*}'.
    $datos[1].'*}'.
    $datos[2].'*}'.
    $datos[3].'*}'.
    $datos[4].'*}'.
    $datos[5];

?>