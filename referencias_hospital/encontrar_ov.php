<?php
require("../Connections/horizonte.php");
require("../funciones/php/values.php");

$id_vc = sqlValue($_POST["id_vc"],"int");
 
mysql_select_db($database_horizonte, $horizonte);
$resultado = mysql_query("SELECT COUNT(vc.id_vc), vc.referencia_vc, ov.id_ov FROM venta_conceptos vc LEFT JOIN orden_venta ov ON ov.referencia_ov = vc.referencia_vc WHERE vc.id_vc = $id_vc", $horizonte) or die (mysql_error());
$datos = mysql_fetch_row($resultado);

echo $datos[0].'*}'.$datos[1].'*}'.$datos[2];

?>