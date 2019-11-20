<?php
require_once('../../../Connections/horizonte.php');

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT concat(nombre_u,' ',apaterno_u) as nombre, amaterno_u, id_u from usuarios order by apaterno_u asc";
$query = mysql_query($consulta) or die (mysql_error());
echo '<option value="">'.'-SELECCIONAR-'.'</option>';

while ($fila = mysql_fetch_array($query)) {
	echo '<option value="'.$fila['id_u'].'">'.$fila['nombre'].' '.$fila['amaterno_u'].'</option>';
};

?>