<?php
require_once('../../Connections/horizonte.php');

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT DISTINCT grupo, id_grupo from catalogo_religiones order by id_grupo asc";
$query = mysql_query($consulta) or die (mysql_error());
echo '<option value="">'.'-SELEECCIONAR-'.'</option>';
while ($fila = mysql_fetch_array($query)) {
	echo '<option value="'.$fila['id_grupo'].'">'.$fila['grupo'].'</option>';
};

?>