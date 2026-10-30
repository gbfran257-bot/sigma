<?php 
require_once('../Connections/horizonte.php');
require("../funciones/php/values.php");


mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT concat_ws(' ', nombre_p, apaterno_p, amaterno_p) as name, id_p as id from pacientes order by fechaR_p DESC LIMIT 2000 ";
$query = mysql_query($consulta) or die (mysql_error());
echo '<option value="">'.'-SELECCIONE AL MÉDICO QUE REFIERE LOS ESTUDIOS-'.'</option>';
while ($fila = mysql_fetch_array($query)) {
	echo '<option value="'.$fila['id'].'">'.$fila['name'].'</option>';
};

?>