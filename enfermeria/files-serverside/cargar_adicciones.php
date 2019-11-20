<?php
require_once('../../Connections/horizonte.php');

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT DISTINCT adiccion_ca, id_ca from catalogo_adicciones order by adiccion_ca asc";
$query = mysql_query($consulta) or die (mysql_error());
echo '<option value="">'.'-ADICCIÓN-'.'</option>';
while ($fila = mysql_fetch_array($query)) {
	echo '<option value="'.$fila['id_ca'].'">'.$fila['adiccion_ca'].'</option>';
};

?>