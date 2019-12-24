<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	$idP = sqlValue($_POST["idP"], "int");
	$idC = sqlValue($_POST["idC"], "int");
	
	if(isset($_POST["x"]) and $_POST["x"]==0){		
		mysql_select_db($database_horizonte, $horizonte);
		$result1 = mysql_query("SELECT nota_interpretacion, id_vc from venta_conceptos where id_vc = $idC limit 1 ", $horizonte) or die (mysql_error());
		$row1 = mysql_fetch_row($result1);
	}else{
	mysql_select_db($database_horizonte, $horizonte);
	$result = mysql_query("SELECT max(vc.id_vc) from venta_conceptos vc left join conceptos c on c.id_to = vc.id_concepto_es where vc.id_paciente_vc = $idP and vc.tipo_concepto_vc = 2 and vc.estatus_vc >= 0 and vc.id_vc not in ($idC) and c.concepto_to != '' and vc.nota_interpretacion != '' limit 1 ", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result); $ultimo = sqlValue($row[0], "int");
	
	mysql_select_db($database_horizonte, $horizonte);
	$result1 = mysql_query("SELECT nota_interpretacion, id_vc from venta_conceptos where id_vc = $ultimo limit 1 ", $horizonte) or die (mysql_error());
 	$row1 = mysql_fetch_row($result1);
	}
			
	echo $row1[1];
 	//Cerrar conexión a la Base de Datos
 	mysql_close($horizonte);
?>