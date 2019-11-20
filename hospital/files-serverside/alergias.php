<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	$idP = sqlValue($_POST["idPac"], "int");

	mysql_select_db($database_horizonte, $horizonte);
	$resultAl = mysql_query("SELECT alergia1_hc, alergia2_hc, alergia3_hc, alergia4_hc, alergia5_hc, alergia6_hc from historia_clinica where id_paciente_hc = $idP ", $horizonte) or die (mysql_error());
 	$rowAl = mysql_fetch_row($resultAl);
	
	if($rowAl[0]=='' and $rowAl[1]=='' and $rowAl[2]=='' and $rowAl[3]=='' and $rowAl[4]=='' and $rowAl[5]==''){$alergias='NINGUNA';}
	else{
		if($rowAl[0]!=''){$aler = $rowAl[0];}
		if($rowAl[1]!=''){$aler = $aler.', '.$rowAl[1];}
		if($rowAl[2]!=''){$aler = $aler.', '.$rowAl[2];}
		if($rowAl[3]!=''){$aler = $aler.', '.$rowAl[3];}
		if($rowAl[4]!=''){$aler = $aler.', '.$rowAl[4];}
		if($rowAl[5]!=''){$aler = $aler.', '.$rowAl[5];}
		if($aler[0]==', '){$alergias = substr($aler, 1);}else{$alergias = $aler;}
	}
		
	$datos = $alergias;
	
	echo $datos;
 	//Cerrar conexión a la Base de Datos
 	mysql_close($horizonte);
?>