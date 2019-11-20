<?php
require_once('../../Connections/horizonte.php');

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT nombre_u, apaterno_u, amaterno_u, id_u from usuarios where acceso_u = 9 order by nombre_u asc";
$query = mysql_query($consulta) or die (mysql_error());
echo '<option value="">'.'-SELEECCIONAR-'.'</option>';
while ($fila = mysql_fetch_array($query)) {
	echo '<option value="'.$fila['id_u'].'">'.$fila['nombre_u'].' '.$fila['apaterno_u'].' '.$fila['amaterno_u'].'</option>';
};

?>