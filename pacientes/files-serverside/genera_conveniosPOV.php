<?php
require_once('../../Connections/horizonte.php');
require("../../funciones/php/values.php");

//$idP = sqlValue($_GET["idP"], "int");

$lista = '0';
mysql_select_db($database_horizonte, $horizonte);
$consulta1 = "SELECT id_convenio_cvp from convenios_paciente where id_paciente_cvp = $_GET[idP] ";
$query1 = mysql_query($consulta1) or die (mysql_error());
while ($fila = mysql_fetch_array($query1)) {
	$lista = $lista.','.$fila['id_convenio_cvp'];
};//echo $lista;

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT id_cv, convenio_cv from convenios where id_cv in ($lista) order by convenio_cv asc ";
$query = mysql_query($consulta) or die (mysql_error());
echo '<option value="">'.'-SELECCIONAR-'.'</option>';
while ($fila = mysql_fetch_array($query)) {
	echo '<option value="'.$fila['id_cv'].'">'.$fila['convenio_cv'].'</option>';
};

?>