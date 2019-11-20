<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	$idP = sqlValue($_POST["idP"], "int");
	$idC = sqlValue($_POST["idC"], "int");
		
	mysql_select_db($database_horizonte, $horizonte);
	$result1 = mysql_query("SELECT v.id_vc from venta_conceptos v left join conceptos c on c.id_to = v.id_concepto_es where v.id_vc < $idC and v.id_paciente_vc = $idP and v.tipo_concepto_vc = 4 and v.estatus_vc = 5 and c.concepto_to != '' and v.area_vc not in (29,58,85) and v.temporal_vc = 0 order by v.id_vc desc limit 1 ", $horizonte) or die (mysql_error());
 	$row1 = mysql_fetch_row($result1);
	
	if($row1[0]==''){
		mysql_select_db($database_horizonte, $horizonte);
		$result1 = mysql_query("SELECT id_vc from venta_conceptos left join conceptos on id_to = id_concepto_es where id_paciente_vc = $idP and tipo_concepto_vc = 4 and estatus_vc = 5 and concepto_to!='' and area_vc not in (29,58,85) and temporal_vc = 0 order by id_vc desc limit 1 ", $horizonte) or die (mysql_error());
		$row1 = mysql_fetch_row($result1);
	}
			
	echo $row1[0];
 	//Cerrar conexión a la Base de Datos
 	mysql_close($horizonte);
?>