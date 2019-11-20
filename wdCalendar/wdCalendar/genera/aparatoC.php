<?php
require_once('../../../Connections/horizonte.php');

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT nombre_eq, id_eq from equipos order by nombre_eq asc";
$query = mysql_query($consulta) or die (mysql_error());
echo '<option value="">'.'-SELECCIONAR-'.'</option>';

while ($fila = mysql_fetch_array($query)) {
	echo '<option value="'.$fila['id_eq'].'">'.$fila['nombre_eq'].'</option>';
};

?>