<?php
require_once('../../Connections/horizonte.php');

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT DISTINCT tipo_sangre, id_tipo_sangre from catalogo_tipo_sangre order by id_tipo_sangre asc";
$query = mysql_query($consulta) or die (mysql_error());
echo '<option value="">'.'-SELECCIONAR-'.'</option>';
while ($fila = mysql_fetch_array($query)) {
	echo '<option value="'.$fila['id_tipo_sangre'].'">'.$fila['tipo_sangre'].'</option>';
};
?>