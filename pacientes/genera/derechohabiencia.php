<?php
require_once('../../Connections/horizonte.php');

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT nombre_dh, id_dh from catalogo_derechohabiencias order by id_dh asc";
$query = mysql_query($consulta) or die (mysql_error());
echo '<option value="">'.'-DERECHOHABIENCIA-'.'</option>';
while ($fila = mysql_fetch_array($query)) {
	echo '<option value="'.$fila['id_dh'].'">'.$fila['nombre_dh'].'</option>';
};
?>