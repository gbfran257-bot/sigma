<?php
require_once('../../Connections/horizonte.php');
require("../../funciones/php/values.php");

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT id_ti as id, titulo_ti as nombre from titulos order by titulo_ti asc ";

$query = mysql_query($consulta) or die (mysql_error());
echo '<option value="">'.'-SELECCIONAR-'.'</option>';
while ($fila = mysql_fetch_array($query)) {
	echo '<option value="'.$fila['id'].'">'.$fila['nombre'].'</option>';
};

?>