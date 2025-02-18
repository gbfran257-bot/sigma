<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$noTemp = sqlValue($_POST["noTemp"], "text");

mysql_select_db($database_horizonte, $horizonte); 
$sql="SELECT count(id_vc) FROM venta_conceptos vc LEFT JOIN conceptos c ON c.id_to = vc.id_concepto_es LEFT JOIN orden_venta ov ON ov.referencia_ov = vc.referencia_vc WHERE c.medicamento_controlado = 1 AND no_temp_vc=$noTemp";
$update = mysql_query($sql, $horizonte) or die (mysql_error());
$row = mysql_fetch_row($update);

echo $row[0];

//Cerrar conexión a la Base de Datos
mysql_close($horizonte);
?>