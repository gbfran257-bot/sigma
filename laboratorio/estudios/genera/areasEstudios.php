<?php
require_once('../../../Connections/horizonte.php');

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT nombre_a, id_a from areas where departamento_a = 1 order by nombre_a asc";
$query = mysql_query($consulta) or die (mysql_error());
echo '<option value="">'.'-SELECCIONAR-'.'</option>';

while ($fila = mysql_fetch_array($query)) {
	echo '<option value="'.$fila['id_a'].'">'.$fila['nombre_a'].'</option>';
};

?>