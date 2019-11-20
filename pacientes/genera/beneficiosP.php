<?php
require_once('../../Connections/horizonte.php');
require("../../funciones/php/values.php");

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT id_convenio_cvp, id_convenio_cvp from convenios_paciente where id_paciente_cvp = '".$_GET['idP']."' order by id_convenio_cvp asc ";
$query = mysql_query($consulta) or die (mysql_error());
echo '<option value="0">'.'-PARTICULAR-'.'</option>';
while ($fila = mysql_fetch_array($query)) {
	$idC = sqlValue($fila['id_convenio_cvp'], "int");
	
	mysql_select_db($database_horizonte, $horizonte); 
	$resultR = mysql_query("SELECT convenio_cv from convenios where id_cv = $idC limit 1 ", $horizonte) or die (mysql_error());
	$rowR = mysql_fetch_row($resultR);
	
	echo '<option value="'.$fila['id_convenio_cvp'].'">'.$rowR[0].'</option>';
};

?>