<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");
$id_vc = sqlValue($_POST["id_vc"], "text");
mysql_select_db($database_horizonte, $horizonte); 
// $sql="select precio_vc, honorarios, precio_original, descuento, motivo_alteracion from venta_conceptos where id_vc=$id_vc";

$sql = "UPDATE venta_conceptos vc LEFT JOIN conceptos e ON e.id_to = vc.id_concepto_es LEFT JOIN areas a ON a.id_a = e.id_area_to LEFT JOIN convenios c ON c.id_cv = vc.id_convenio_vc SET vc.descuento = 0 WHERE vc.no_temp_vc = $id_vc AND e.id_tipo_concepto_to = 4";
echo $sql;
$update = mysql_query($sql, $horizonte) or die (mysql_error());
if (!$update) { echo $sql; }else{ 
	$dat = mysql_fetch_row($update);
	echo json_encode($dat);
}

//Cerrar conexión a la Base de Datos
mysql_close($horizonte);
?>