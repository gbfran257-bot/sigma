<?php
require_once('../../Connections/horizonte.php');

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT DISTINCT estatus_ev, id_ev from estatus_vivo order by estatus_ev asc";
$query = mysql_query($consulta) or die (mysql_error());
echo '<option value="">'.'-ESTATUS-'.'</option>';
while ($fila = mysql_fetch_array($query)) {
	echo '<option value="'.$fila['id_ev'].'">'.$fila['estatus_ev'].'</option>';
};

?>