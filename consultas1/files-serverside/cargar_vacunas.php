<?php
require_once('../../Connections/horizonte.php');

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT DISTINCT vacuna_v, id_v from catalogo_vacunas order by vacuna_v asc";
$query = mysql_query($consulta) or die (mysql_error());
echo '<option value="">'.'-SELECCIONAR-'.'</option>';
while ($fila = mysql_fetch_array($query)) {
	echo '<option value="'.$fila['id_v'].'">'.$fila['vacuna_v'].'</option>';
};

?>