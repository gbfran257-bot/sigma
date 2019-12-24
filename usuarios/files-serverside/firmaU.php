<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$temporalU = sqlValue($_POST["temporalU"], "text");

mysql_select_db($database_horizonte, $horizonte);
$result1 = mysql_query("SELECT firma_u from usuarios where temporal_u = $temporalU ", $horizonte) or die (mysql_error());
$row1 = mysql_fetch_row($result1);

mysql_select_db($database_horizonte, $horizonte);
$result2 = mysql_query("SELECT count(id_do) from documentos where nombre_do = $temporalU ", $horizonte) or die (mysql_error());
$row2 = mysql_fetch_row($result2);

	echo $row2[0].'*';

mysql_close($horizonte);
?>