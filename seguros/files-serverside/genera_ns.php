<?php
require_once('../../Connections/horizonte.php');

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT DISTINCT ns_ns, id_ns from catalogo_ns order by ns_ns asc";
$query = mysql_query($consulta) or die (mysql_error());
echo '<option value="">'.'-SELEECCIONAR-'.'</option>';
while ($fila = mysql_fetch_array($query)) {
	echo '<option value="'.$fila['id_ns'].'">'.$fila['ns_ns'].'</option>';
};

?>