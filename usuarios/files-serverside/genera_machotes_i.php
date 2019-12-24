<?php
require_once('../../Connections/horizonte.php');
require("../../funciones/php/values.php");

$id_u = sqlValue($_GET["id_u"], "int");
$id_es = sqlValue($_GET["id_es"], "int");

mysql_select_db($database_horizonte, $horizonte);
$result = mysql_query("SELECT temporal_u from usuarios where id_u = $id_u ", $horizonte) or die (mysql_error());
$row = mysql_fetch_row($result); $tempor = sqlValue($row[0], "text");

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT nombre_fc as name, id_fc as id from formatos_conceptos where id_concepto_fc = $id_es and temporal_fc = $tempor order by name asc";
$query = mysql_query($consulta) or die (mysql_error());
echo '<option value="">'.'-PUEDES SELEECCIONAR UN MACHOTE PARA ESTE ESTUDIO-'.'</option>';
while ($fila = mysql_fetch_array($query)) {
	echo '<option value="'.$fila['id'].'">'.$fila['name'].'</option>';
};

?>