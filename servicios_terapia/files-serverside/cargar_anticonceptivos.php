<?php
require_once('../../Connections/horizonte.php');

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT DISTINCT anticonceptivo_at, id_at from catalogo_anticonceptivos order by anticonceptivo_at asc";
$query = mysql_query($consulta) or die (mysql_error());
echo '<option value="">'.'-SELECCIONAR-'.'</option>';
while ($fila = mysql_fetch_array($query)) {
	echo '<option value="'.$fila['id_at'].'">'.$fila['anticonceptivo_at'].'</option>';
};

?>