<?php 
require_once('../../Connections/horizonte.php');
require("../../funciones/php/values.php");

	mysql_select_db($database_horizonte, $horizonte);
	$consulta1 = "SELECT DISTINCT id_pr, procedencia_pr from procedencia where id_pr = 1 order by procedencia_pr asc"; 
	//$consulta1 = "SELECT DISTINCT id_pr, procedencia_pr from procedencia order by procedencia_pr asc"; covadonga
	$query1 = mysql_query($consulta1) or die (mysql_error());
	while ($fila1 = mysql_fetch_array($query1)) { echo '<option value="'.$fila1['id_pr'].'">'.$fila1['procedencia_pr'].'</option>'; };

?>