<?php
require_once('../../Connections/horizonte.php');

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT DISTINCT escolaridad, id_escolaridad from catalogo_escolaridad order by id_escolaridad asc";
$query = mysql_query($consulta) or die (mysql_error());
echo '<option value="">'.'-SELEECCIONAR-'.'</option>';
while ($fila = mysql_fetch_array($query)) {
	echo '<option value="'.$fila['id_escolaridad'].'">'.$fila['escolaridad'].'</option>';
};

?>