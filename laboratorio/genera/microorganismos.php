<?php
require_once('../../Connections/horizonte.php');
require("../../funciones/php/values.php");

$idE=sqlValue($_POST["idE"],"int");

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT id_b as id, base_b as name from bases where base_b like '%_MIORG' order by name asc";

$query = mysql_query($consulta) or die (mysql_error());
echo '<option value="">'.'-SELEECCIONAR-'.'</option>';
while ($fila = mysql_fetch_array($query)){ $name = explode("_MIORG", $fila['name']);
	echo '<option value="'.$fila['id'].'">'.$name[0].'</option>';
};
?>