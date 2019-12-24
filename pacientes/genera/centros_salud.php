<?php
require_once('../../Connections/horizonte.php');

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT DISTINCT nombre_cs, id_cs from catalogo_centro_salud order by nombre_cs asc";
$query = mysql_query($consulta) or die (mysql_error());
echo '<option value="">'.'-CENTRO DE SALUD-'.'</option>';
while ($fila = mysql_fetch_array($query)) {
	echo '<option value="'.$fila['id_cs'].'">'.$fila['nombre_cs'].'</option>';
};
?>