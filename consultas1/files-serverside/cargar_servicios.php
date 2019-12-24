<?php
require_once('../../Connections/horizonte.php');

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT DISTINCT servicio_cs, id_cs from catalogo_servicios order by servicio_cs asc";
$query = mysql_query($consulta) or die (mysql_error());
echo '<option value="">'.'-SELECCIONAR-'.'</option>';
while ($fila = mysql_fetch_array($query)) {
	echo '<option value="'.$fila['id_cs'].'">'.$fila['servicio_cs'].'</option>';
};

?>