<?php
require_once('../../Connections/horizonte.php');

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT DISTINCT grupo_etnico, id_grupo_etnico from catalogo_grupo_etnico order by grupo_etnico asc";
$query = mysql_query($consulta) or die (mysql_error());
echo '<option value="">'.'-SELEECCIONAR-'.'</option>';
while ($fila = mysql_fetch_array($query)) {
	echo '<option value="'.$fila['id_grupo_etnico'].'">'.$fila['grupo_etnico'].'</option>';
};

?>