<?php
require_once('../../Connections/horizonte.php');

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT DISTINCT nombre_ef, id_ef from enfermedades order by nombre_ef asc";
$query = mysql_query($consulta) or die (mysql_error());
echo '<option value="">'.'-ENFERMEDAD-'.'</option>';
while ($fila = mysql_fetch_array($query)) {
	echo '<option value="'.$fila['id_ef'].'">'.$fila['nombre_ef'].'</option>';
};

?>