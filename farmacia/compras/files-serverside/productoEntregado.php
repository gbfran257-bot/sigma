<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

$idCompra = sqlValue($_POST["idP"], "int");
$idU = sqlValue($_POST["idU"], "int");
$now = sqlValue(date('Y-m-d H:i:s'), "date");

mysql_select_db($database_horizonte, $horizonte);
$sql = "UPDATE stock_has_bach SET estatus = 1, usuario_registro = $idU, fecha_update= $now WHERE id =$idCompra";
 
$update = mysql_query($sql, $horizonte) or die (mysql_error());

if (!$update) {
    echo $sql;
} else{ 
    echo 1; 
}


?>