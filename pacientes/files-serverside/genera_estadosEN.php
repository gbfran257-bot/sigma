<?php
require_once('../../Connections/horizonte.php');

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT id_mx, d_estado from mexico where d_estado != '' group by d_estado ";
$query = mysql_query($consulta) or die (mysql_error());
echo '<option value="">'.'-ENTIDAD FEDERATIVA DE NACIMIENTO-'.'</option>';
while ($fila = mysql_fetch_array($query)) {
	echo '<option value="'.$fila['id_mx'].'">'.$fila['d_estado'].'</option>';
};

?>