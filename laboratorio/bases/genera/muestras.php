<?php
require_once('../../../Connections/horizonte.php');

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT concat(m.muestra_mu,' (',c.condicion_co,')') as name, m.id_mu as id from muestras m left join condiciones c on c.id_co = m.id_condicion_mu order by m.muestra_mu asc";
$query = mysql_query($consulta) or die (mysql_error());
echo '<option value="">'.'-SELEECCIONAR-'.'</option>';
while ($fila = mysql_fetch_array($query)) {
	echo '<option value="'.$fila['id'].'">'.$fila['name'].'</option>';
};

?>