<?php
require_once('../../Connections/horizonte.php');
require("../../funciones/php/values.php");

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT id_nm, nombre_nm from notas_medicas where tipo_nm = 1 order by nombre_nm asc ";
$query = mysql_query($consulta) or die (mysql_error());
echo '<option value="">'.'-Nota Médica-'.'</option>';
while ($fila = mysql_fetch_array($query)) {
	echo '<option value="'.$fila['id_nm'].'">'.$fila['nombre_nm'].'</option>';
};

?>