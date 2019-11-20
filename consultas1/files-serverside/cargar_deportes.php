<?php
require_once('../../Connections/horizonte.php');

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT DISTINCT deporte_dp, id_dp from deportes order by deporte_dp asc";
$query = mysql_query($consulta) or die (mysql_error());
echo '<option value="">'.'-DEPORTE-'.'</option>';
while ($fila = mysql_fetch_array($query)) {
	echo '<option value="'.$fila['id_dp'].'">'.$fila['deporte_dp'].'</option>';
};

?>