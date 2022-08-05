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

echo $rowR[0]."}{[_}".$rowR[1]."}{[_}".$rowR1[0]."}{[_}".$rowR1[1];
?>