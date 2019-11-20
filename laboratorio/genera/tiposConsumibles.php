<?php
require_once('../../Connections/horizonte.php');

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT DISTINCT tipo_cti as name, id_cti as id from catalogo_tipo_inventario order by name asc";
$query = mysql_query($consulta) or die (mysql_error());
echo '<option value="">'.'-SELEECCIONAR-'.'</option>';
while ($fila = mysql_fetch_array($query)){
	echo '<option value="'.$fila['id'].'">'.$fila['name'].'</option>';
};
?>