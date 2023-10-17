<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

$id_su = sqlValue($_POST['id_su'],"int");
$idProd = sqlValue($_POST['prod'],"int"); 
// $costoVal = sqlValue($_POST['costoVal'],"int"); 


mysql_select_db($database_horizonte, $horizonte);
$resultR = mysql_query("SELECT concepto_to, precio_to from conceptos where id_to = $idProd ", $horizonte) or die(mysql_error());
$rowR = mysql_fetch_row($resultR);


mysql_select_db($database_horizonte, $horizonte);
$resultR1 = mysql_query("SELECT s.max_mm, s.min_mm from max_min_stock s where s.id_producto = $idProd AND s.id_suc = $id_su", $horizonte) or die(mysql_error());
$rowR1 = mysql_fetch_row($resultR1);

// Obtenemos el precio del medicamento seleccionado en la última compra en la que se agregó //
mysql_select_db($database_horizonte, $horizonte);
$resultado_precio_medicamento_ultima_compra = mysql_query("SELECT costo_unitario FROM stock_has_bach WHERE id_Producto = {$idProd} ORDER BY id DESC LIMIT 1", $horizonte) or die(mysql_error());
$precio_medicamento = mysql_fetch_object($resultado_precio_medicamento_ultima_compra);

echo $rowR[0]."}{[_}".$rowR[1]."}{[_}".$rowR1[0]."}{[_}".$rowR1[1] . "}{[_}" . $precio_medicamento->costo_unitario;
?>