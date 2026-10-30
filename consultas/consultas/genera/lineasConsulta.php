<?php
require_once('../../../Connections/horizonte.php');

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT nombre_l, id_l from catalogo_lineas_cr where 1= 1 order by nombre_l asc";
$query = mysql_query($consulta) or die (mysql_error());
echo '<option value="">'.'-SELECCIONAR-'.'</option>';

while ($fila = mysql_fetch_array($query)) {
	echo '<option value="'.$fila['nombre_l'].'">'.$fila['nombre_l'].'</option>';
};

?>