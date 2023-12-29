<?php
require("../Connections/horizonte.php");
require("../funciones/php/values.php");

$id_paciente = sqlValue($_POST["id_paciente"],"int");
 
mysql_select_db($database_horizonte, $horizonte);
$resultado = mysql_query("SELECT COUNT(id_rh), id_rh, referencia_rh FROM referencias_hospital WHERE id_paciente_rh = $id_paciente AND estado_rh = 0 ORDER BY fecha_rh DESC LIMIT 1", $horizonte) or die (mysql_error());
$datos = mysql_fetch_row($resultado);

echo $datos[0].'*}'.$datos[1].'*}'.$datos[2];

?>