<?php
require_once('../../../Connections/horizonte.php');

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT concat(i.item_i,' (',descripcion_i,')') as name, i.id_i as id from inventario i order by i.item_i asc";
$query = mysql_query($consulta) or die (mysql_error());
echo '<option value="">'.'-SELEECCIONAR-'.'</option>';
while ($fila = mysql_fetch_array($query)) {
	echo '<option value="'.$fila['id'].'">'.$fila['name'].'</option>';
};

?>