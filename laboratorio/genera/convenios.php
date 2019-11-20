<?php
require_once('../../Connections/horizonte.php');

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT id_cv, convenio_cv from convenios order by convenio_cv asc";
$query = mysql_query($consulta) or die (mysql_error());

echo '<option value="">'.'-CONVENIO-'.'</option>';
echo '<option value="0">'.'PARTICULAR'.'</option>';

while ($fila = mysql_fetch_array($query)) {
	echo '<option value="'.$fila['id_cv'].'">'.$fila['convenio_cv'].'</option>';
};

?>