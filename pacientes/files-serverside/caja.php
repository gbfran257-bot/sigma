<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT DISTINCT caja from pagos_ov where caja is not null";
$query = mysql_query($consulta) or die (mysql_error());
echo '<option value="">'.'-CAJA-'.'</option>';
while ($fila = mysql_fetch_array($query)) {
	echo '<option value="'.$fila['caja'].'">'.$fila['caja'].'</option>';
};



?>