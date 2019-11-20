<?php
require_once('../../../Connections/horizonte.php');

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT nombre_d, id_d from departamentos where clave_d in ('LAB') order by id_d asc";
$query = mysql_query($consulta) or die (mysql_error());
//echo '<option value="">'.'-SELEECCIONAR-'.'</option>';
while ($fila = mysql_fetch_array($query)) {
	echo '<option value="'.$fila['id_d'].'">'.$fila['nombre_d'].'</option>';
};

?>