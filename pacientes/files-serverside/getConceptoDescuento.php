<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$id = sqlValue($_POST["no_temp_vc"], "text");
mysql_select_db($database_horizonte, $horizonte); 
$sql = "SELECT motivo_alteracion, descuento FROM venta_conceptos WHERE no_temp_vc = $id and descuento > 0";
$query = mysql_query($sql, $horizonte) or die(mysql_error());

$results = array();

while ($fila = mysql_fetch_array($query)) {
	$montoDescuento = "(".$fila['descuento'].")";
    $results[] = $fila['motivo_alteracion'] . $montoDescuento;
}

echo json_encode($results);

mysql_close($horizonte);


?>