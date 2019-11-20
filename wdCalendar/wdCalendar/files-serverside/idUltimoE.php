<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

mysql_select_db($database_horizonte, $horizonte);
//$result1 = mysql_query("SELECT MAX(Id) from jqcalendar limit 1 ", $horizonte) or die (mysql_error());
$result1 = mysql_query("SELECT AUTO_INCREMENT from information_schema.TABLES WHERE TABLE_SCHEMA = 'sigma-nuevo' AND TABLE_NAME = 'jqcalendar'", $horizonte) or die (mysql_error());
$row1 = mysql_fetch_row($result1);

echo $row1[0];

mysql_close($horizonte);
?>