<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idP = sqlValue($_POST["idPac"], "int");
 $idE = sqlValue($_POST["idConsul"], "int");

	mysql_select_db($database_horizonte, $horizonte);
	$result1 = mysql_query("SELECT referencia_vc, interpretacion_vc, nota_interpretacion, date_format(fecha_venta_vc,'%d/%c/%Y'), id_paciente_vc, id_personal_medico_vc, id_concepto_es, usuarioEdo5_e, contador_vc, area_vc, nota_radiologo_vc, usuarioEdo5_e, referencia_vc, DATE_FORMAT(fecha_venta_vc,'%Y%m%d'), area_vc from venta_conceptos where id_vc = $idE ", $horizonte) or die (mysql_error());
 	$row1 = mysql_fetch_row($result1);
		
	$result2 = mysql_query("SELECT nombre_u, apaterno_u, amaterno_u from usuarios where id_u = $row1[5] ", $horizonte) or die (mysql_error());
 	$row2 = mysql_fetch_row($result2);
	
	$result3 = mysql_query("SELECT concepto_to from conceptos where id_to = $row1[6] ", $horizonte) or die (mysql_error());
 	$row3 = mysql_fetch_row($result3);
	
	$idUi = sqlValue($row1[11], "int");
	$result4 = mysql_query("SELECT nombre_u, apaterno_u, amaterno_u, cedulaProfesional_u, id_u, sexo_u from usuarios where id_u = $idUi ", $horizonte) or die (mysql_error());
 	$row4 = mysql_fetch_row($result4);
	
	$medicoEstudio = $row2[0]." ".$row2[1]." ".$row2[2];
	$medicoInterpreta = $row4[0]." ".$row4[1]." ".$row4[2];
	/*
	if($row[9] != 55){
		$referenciaPacs = $row1[0];
	}else{$referenciaPacs = $row1[0]."-".$row1[8];}
	
	$referenciaPacs = substr($referenciaPacs, 2);
	$referenciaPacs = str_replace("-","",$referenciaPacs);*/
	
	$now1 = $row1[13];
	if($now1<20160123){//if($now1<20151008  20160123){ aqui hay un pedo
		//Si el area es RAYOS X entonces la referencia del pacs será la referencia de la orden de venta
		$miRef = substr($row1[12], 2); $miRef = str_replace("-","",$miRef);
		if($row1[9]!=55){
			$referenciaPacs = $miRef;
		}else{
			$referenciaPacs = $miRef.$row1[8];
		}
	}else{
		$miRef = substr($row1[12], 2); $miRef = str_replace("-","",$miRef);
		if($row1[9]==55){
			$referenciaPacs = $miRef;
		}else{ //Preguntar si los rayos se van a agrupar en el pacs
			$referenciaPacs = $miRef.$row1[8];
		}
	}
	
	$datos = $row1[0].';*-'.$row1[0].';*-'.$row1[0].';*-'.$row1[1].";*-".$row1[3].";*-".$row1[1].";*-".$row1[2].";*-".$medicoEstudio.";*-".$row3[0].";*-".$medicoInterpreta.";*-".$row4[3].";*-".$row1[7].".png".";*-".$referenciaPacs.";*-".$row1[10].";*-".$row1[4].";*-".$row4[5];
	
echo $datos;
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>