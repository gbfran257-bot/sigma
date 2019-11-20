<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idC = sqlValue($_POST["idC"], "int");
 $idU = sqlValue($_POST["idU"], "int");
 $notaDictamen = sqlValue($_POST["notaDictamen"], "text");
 $notaReceta = sqlValue($_POST["indiF"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 $idP = sqlValue($_POST["idP"], "int");
 $recetaR = sqlValue($_POST["recetaR"], "text");
 $indiF = sqlValue($_POST["indiF"], "text");
 
 mysql_select_db($database_horizonte, $horizonte);
 $resultS=mysql_query("SELECT MAX(id_sv) from signos_vitales where id_paciente_sv = $idP limit 1 ",$horizonte) or die (mysql_error());
 $rowS = mysql_fetch_row($resultS); $idSV = sqlValue($rowS[0], "int");
 
 //checamos si la consulta está finalizada, si es así, entonces no guardamos el id de los Signos Vitales
 mysql_select_db($database_horizonte, $horizonte);
 $res1=mysql_query("SELECT estatus_vc, id_vc from venta_conceptos where id_vc = $idC limit 1 ",$horizonte) or die (mysql_error());
 $rowSV1a = mysql_fetch_row($res1);
 if($rowSV1a!=6){//Si no esta finalizada
 	mysql_select_db($database_horizonte, $horizonte);
 	$sql = "UPDATE venta_conceptos SET estatus_vc = 6, usuarioEdo3_e = $idU, fechaEdo3_e = $now, temporal_vc = 0, id_signosv_vc = $idSV where id_vc = $idC limit 1";
 	$update = mysql_query($sql, $horizonte) or die (mysql_error());
 }else{
	mysql_select_db($database_horizonte, $horizonte);
 	$sql = "UPDATE venta_conceptos SET estatus_vc = 6 where id_vc = $idC limit 1";
 	$update = mysql_query($sql, $horizonte) or die (mysql_error());
 }
  	
if (!$update) { echo $sql; }else{
	mysql_select_db($database_horizonte, $horizonte);
 	$sql1 = "UPDATE dx_consultas SET temp_dxc = 0 where id_c_dxc = $idC ";
 	$update1 = mysql_query($sql1, $horizonte) or die (mysql_error());
 	
	if (!$update1) { echo $sql1; }else{
		mysql_select_db($database_horizonte, $horizonte);
 		$sql2 = "UPDATE medicamentos_receta SET temp_mr = 0 where id_co_mr = $idC ";
 		$update2 = mysql_query($sql2, $horizonte) or die (mysql_error());
		
		if (!$update2) { echo $sql2; }
		else{
			mysql_select_db($database_horizonte, $horizonte);
 			$sql3 = "UPDATE venta_conceptos SET nota_interpretacion = $notaDictamen, nota_receta = $notaReceta, otras_indicaciones = $recetaR, nota_radiologo_vc = $indiF, salvado_vc = 1 where id_vc = $idC limit 1 ";
 			$update3 = mysql_query($sql3, $horizonte) or die (mysql_error());
			
			if (!$update3) { echo $sql3; } else{ echo '1'.';{}'.$rowSV1a[1].';{}'.$_POST["idP"]; }
		}
	}
}
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>