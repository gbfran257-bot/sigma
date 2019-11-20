<?php
require_once('../../Connections/horizonte.php');

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT DISTINCT tipo_discapacidad, id_discapacidad from catalogo_discapacidades order by tipo_discapacidad asc";
$query = mysql_query($consulta) or die (mysql_error());
echo '<option value="">'.'-SELEECCIONAR-'.'</option>';
while ($fila = mysql_fetch_array($query)) {
	echo '<option value="'.$fila['id_discapacidad'].'">'.$fila['tipo_discapacidad'].'</option>';
};

?>