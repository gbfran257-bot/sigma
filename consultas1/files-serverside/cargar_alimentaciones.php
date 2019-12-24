<?php
require_once('../../Connections/horizonte.php');

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT DISTINCT alimentacion_ta, id_ta from catalogo_tipo_alimentacion order by alimentacion_ta asc";
$query = mysql_query($consulta) or die (mysql_error());
echo '<option value="">'.'-SELECCIONAR-'.'</option>';
while ($fila = mysql_fetch_array($query)) {
	echo '<option value="'.$fila['id_ta'].'">'.$fila['alimentacion_ta'].'</option>';
};

?>