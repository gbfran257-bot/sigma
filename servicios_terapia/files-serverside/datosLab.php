<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	$idP = sqlValue($_POST["idP"], "int");
	$idC = $_POST["idC"]; //'$_GET[aleatorio]'

	mysql_select_db($database_horizonte, $horizonte);
	$result = mysql_query("SELECT id_vc, estatus_vc from venta_conceptos where id_paciente_vc = $idP and tipo_concepto_vc = 3 and estatus_vc > 6 and temporal_vc = 0 order by id_vc desc limit 1 ", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result); $ultimo = sqlValue($row[0], "int");
			
	echo $ultimo.'{;}'.$row[1];
 	//Cerrar conexión a la Base de Datos
 	mysql_close($horizonte);
?>