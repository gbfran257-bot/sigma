<?php
require_once('../../Connections/horizonte.php');

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT DISTINCT inicio_ci, id_ci from catalogo_inicios order by inicio_ci asc";
$query = mysql_query($consulta) or die (mysql_error());
echo '<option value="">'.'-SELECCIONAR-'.'</option>';
while ($fila = mysql_fetch_array($query)) {
	echo '<option value="'.$fila['id_ci'].'">'.$fila['inicio_ci'].'</option>';
};

?>