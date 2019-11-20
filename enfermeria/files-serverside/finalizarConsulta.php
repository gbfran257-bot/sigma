<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $noTemp = sqlValue($_POST["noAleatorio"], "text");
 $observacionesC = sqlValue($_POST["observacionesC"], "text");
 $idU = sqlValue($_POST["idU"], "int");
 $notaDictamen = sqlValue($_POST["notaDictamen"], "text");
 $notaReceta = sqlValue($_POST["notaReceta"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 $idP = sqlValue($_POST["idP"], "int");
 
 mysql_select_db($database_horizonte, $horizonte);
 $resultS = mysql_query("SELECT MAX(id_sv) from signos_vitales where id_paciente_sv = $idP limit 1 ", $horizonte) or die (mysql_error());
 $rowS = mysql_fetch_row($resultS); $idSV = sqlValue($rowS[0], "int");
	
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "UPDATE venta_conceptos SET estatus_vc = 6, usuarioEdo3_e = $idU, fechaEdo3_e = $now, temporal_vc = 0, id_signosv_vc = $idSV  where no_temp_vc = $noTemp and tipo_concepto_vc = 1 limit 1";
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
  	
if (!$update) { echo $sql; }else{
	mysql_select_db($database_horizonte, $horizonte);
 	$sql1 = "UPDATE dx_consultas SET temp_dxc = 0 where no_temp_dxc = $noTemp ";
 	$update1 = mysql_query($sql1, $horizonte) or die (mysql_error());
 	
	if (!$update1) { echo $sql1; }else{
		mysql_select_db($database_horizonte, $horizonte);
 		$sql2 = "UPDATE medicamentos_receta SET temp_mr = 0 where no_temp_mr = $noTemp ";
 		$update2 = mysql_query($sql2, $horizonte) or die (mysql_error());
		
		if (!$update2) { echo $sql2; }
		else{
			mysql_select_db($database_horizonte, $horizonte);
 			$sql3 = "UPDATE venta_conceptos SET observaciones_vc = $observacionesC, nota_interpretacion = $notaDictamen, nota_receta = $notaReceta where no_temp_vc = $noTemp and tipo_concepto_vc = 1 limit 1 ";
 			$update3 = mysql_query($sql3, $horizonte) or die (mysql_error());
			
			if (!$update3) { echo $sql3; } else{ echo 1; }
		}
	}
}
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>