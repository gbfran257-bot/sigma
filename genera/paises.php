<?php
require_once('../Connections/horizonte.php');
require("../funciones/php/values.php");

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT PAI_PK as id, UPPER(PAI_NOMBRE) as nombre from pais order by nombre asc ";
$query = mysql_query($consulta) or die (mysql_error());
echo '<option value="">'.'-SELECCIONAR-'.'</option>';
while ($fila = mysql_fetch_array($query)) {
	echo '<option value="'.$fila['id'].'">'.$fila['nombre'].'</option>';
};

?>