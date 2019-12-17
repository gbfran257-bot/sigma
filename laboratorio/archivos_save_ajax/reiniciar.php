<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idEvc = sqlValue($_POST["idEvc"], "int");
 
mysql_select_db($database_horizonte, $horizonte);
	$sql = "UPDATE venta_conceptos SET estatus_vc = 1 where id_vc = $idEvc ";
	$update = mysql_query($sql, $horizonte);
	
	if (!$update) { echo $sql; }
	else {
		mysql_select_db($database_horizonte, $horizonte);
		$sqlNotaToma = "DELETE from resultados_laboratorio where id_estudio_vc_rl = $idEvc ";
		$updateNotaToma = mysql_query($sqlNotaToma, $horizonte);
		
		if (!$updateNotaToma) { echo $sqlNotaToma; }
		else { echo 1; }
	}
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>