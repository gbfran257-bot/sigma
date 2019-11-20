<?php
require_once('../../Connections/horizonte.php');

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT DISTINCT unidad_un as name, abreviacion_un as abre, id_un as id from unidades where unidad_un != '' order by name asc";
$query = mysql_query($consulta) or die (mysql_error());
echo '<option value="">'.'-SELEECCIONAR-'.'</option>';
while ($fila = mysql_fetch_array($query)){
	echo '<option value="'.$fila['id'].'('.$fila['abre'].')">'.$fila['name'].'</option>';
};
?>