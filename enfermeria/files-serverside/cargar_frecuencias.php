<?php
require_once('../../Connections/horizonte.php');

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT DISTINCT frecuencia_cf, if_cf from catalogo_frecuencias order by frecuencia_cf asc";
$query = mysql_query($consulta) or die (mysql_error());
echo '<option value="">'.'-SELECCIONAR-'.'</option>';
while ($fila = mysql_fetch_array($query)) {
	echo '<option value="'.$fila['if_cf'].'">'.$fila['frecuencia_cf'].'</option>';
};

?>