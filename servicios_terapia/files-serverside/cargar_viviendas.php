<?php
require_once('../../Connections/horizonte.php');

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT DISTINCT concepto_vivienda, id_vivienda from catalogo_vivienda order by concepto_vivienda asc";
$query = mysql_query($consulta) or die (mysql_error());
echo '<option value="">'.'-SELECCIONAR-'.'</option>';
while ($fila = mysql_fetch_array($query)) {
	echo '<option value="'.$fila['id_vivienda'].'">'.$fila['concepto_vivienda'].'</option>';
};

?>