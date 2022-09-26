<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");
$id_medi = sqlValue($_POST["id_medi"], "int");
$id_su = sqlValue($_POST["id_su"], "int");

mysql_select_db($database_horizonte, $horizonte);
$result = mysql_query("SELECT m.max_mm, m.min_mm from max_min_stock m where m.id_producto = $id_medi and m.id_suc = $id_su", $horizonte) or die(mysql_error());
$row = mysql_fetch_row($result); 

echo $row[0].'}{[_}'.$row[1];
?>