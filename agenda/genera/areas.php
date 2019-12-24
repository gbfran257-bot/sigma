<?php
require_once('../../Connections/horizonte.php');
require("../../funciones/php/values.php");

$id_depto = sqlValue($_GET["idd"], "int");

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT id_a as id, nombre_a as nombre from areas where departamento_a = $id_depto order by nombre asc ";
$query = mysql_query($consulta) or die (mysql_error());
echo '<option value="" selected>'.'-ÁREA-'.'</option>';
while ($fila = mysql_fetch_array($query)) {
	echo '<option value="'.$fila['id'].'">'.$fila['nombre'].'</option>';
};

?>