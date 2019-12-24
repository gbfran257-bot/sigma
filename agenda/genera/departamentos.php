<?php
require_once('../../Connections/horizonte.php');
require("../../funciones/php/values.php");

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT id_d as id, nombre_d as nombre from departamentos where id_d in (4,11,2,1,13,12,10,6,18) order by nombre asc ";
$query = mysql_query($consulta) or die (mysql_error());
echo '<option value="" selected>'.'-DEPARTAMENTO-'.'</option>';
while ($fila = mysql_fetch_array($query)) {
	echo '<option value="'.$fila['id'].'">'.$fila['nombre'].'</option>';
};

?>