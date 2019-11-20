<?php
require_once('../../Connections/horizonte.php');

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT DISTINCT presentacion_cp as name, id_cp as id from catalogo_presentaciones order by name asc";
$query = mysql_query($consulta) or die (mysql_error());
echo '<option value="">'.'-SELEECCIONAR-'.'</option>';
while ($fila = mysql_fetch_array($query)){
	echo '<option value="'.$fila['id'].'">'.$fila['name'].'</option>';
};
?>