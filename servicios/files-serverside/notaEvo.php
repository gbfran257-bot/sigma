<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	$idP = sqlValue($_POST["idPac"], "int");
	$idC = sqlValue($_POST["idConsul"], "int");

	mysql_select_db($database_horizonte, $horizonte);
	$result = mysql_query("SELECT nombre_p, apaterno_p, amaterno_p, fNac_p, sexo_p, calle_p, id_p, entidadFederativa_p, municipio_p, colonia_p, cp_p, curp_p from pacientes where id_p = $idP ", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result); $fx = $row[3];
	$idEstadoP = sqlValue($row[7], "int"); $idMunicipioP = sqlValue($row[8], "int"); $idColoniaP = sqlValue($row[9], "int");
	
	mysql_select_db($database_horizonte, $horizonte); 
 $resultEP = mysql_query("SELECT d_estado from mexico where id_mx = $idEstadoP limit 1", $horizonte) or die (mysql_error());
 $rowEP = mysql_fetch_row($resultEP);
 
 mysql_select_db($database_horizonte, $horizonte); 
 $resultMP = mysql_query("SELECT d_municipio from mexico where id_mx = $idMunicipioP limit 1", $horizonte) or die (mysql_error());
 $rowMP = mysql_fetch_row($resultMP);
 
 mysql_select_db($database_horizonte, $horizonte); 
 $resultCP = mysql_query("SELECT d_asenta from mexico where id_mx = $idColoniaP limit 1", $horizonte) or die (mysql_error());
 $rowCP = mysql_fetch_row($resultCP);
 
 if($rowP[4]!='' and $rowCP[0]!='' and $rowMP[0]!='' and $rowEP[0]!=''){
	 $direccionP = 'CALLE '.$rowP[4].' #'.$rowP[5].' COLONIA '.$rowCP[0].', '.$rowMP[0].', '.$rowEP[0];
 }else{$direccionP = '';}
	
	//para la edad
	$fecha1 = new DateTime($fx); $fecha2 = new DateTime(date("Y-m-d H:i:s")); $fecha = $fecha1->diff($fecha2);

	$anos=$fecha->y; $meses=$fecha->m; $dias=$fecha->d; $horas=$fecha->h; $minutos=$fecha->i; $segundos=$fecha->s;
	if($anos>0){$fx=$anos." AÑOS";}
	if($anos<1){
		if($meses<=2 and $meses>=1){$fx=$meses." MES(ES) ".$dias." DÍA(S)";}
		if($meses>=3){$fx=$meses." MES(ES) ";}
		if($meses==0){$fx=$dias." DÍA(S)";}
		if($meses==0 and $dias<=1){$fx=$dias." DÍA(S) ".$horas." HORA(S)";}
		if($meses==0 and $dias<1){$fx=$horas." HORA(S) ".$minutos." MINUTO(S)";}
	} 
	if($anos>150 or $anos<0){$fx="DESCONOCIDA";}else{}
	
	//para el sexo
	switch($row[4]){
		case 1: $row[4] = "FEMENINO"; break;
		case 2: $row[4] = "MASCULINO"; break;
		case 3: $row[4] = "AMBIGUO"; break;
		case 4: $row[4] = "NO APLICA"; break;
		case 99: $row[4] = "SIN ASIGNACIÓN"; break;
	}
	
	mysql_select_db($database_horizonte, $horizonte);
	$resultC = mysql_query("SELECT no_temp_vc, DATE_FORMAT(fechaEdo3_e, '%e'), DATE_FORMAT(fechaEdo3_e, '%c'), DATE_FORMAT(fechaEdo3_e, '%Y'), usuarioEdo3_e, DATE_FORMAT(fechaEdo3_e, '%H'), DATE_FORMAT(fechaEdo3_e, '%i'), DATE_FORMAT(fechaEdo3_e, '%s'), id_signosv_vc, id_concepto_es, id_personal_medico_vc from venta_conceptos where id_vc = $idC limit 1", $horizonte) or die (mysql_error());
 	$rowC = mysql_fetch_row($resultC); $idSVC1 = sqlValue($rowC[8], "int"); $idDR = sqlValue($rowC[4], "int");
	$idConc = sqlValue($rowC[9], "int"); $idAquien = sqlValue($rowC[10], "int"); $idAquien1 = sqlValue($rowC[4], "int");
	
	mysql_select_db($database_horizonte, $horizonte);
	$resultAQ=mysql_query("SELECT nombre_u, apaterno_u, amaterno_u from usuarios where id_u = $idAquien ", $horizonte) or die (mysql_error());
 	$rowAQ = mysql_fetch_row($resultAQ);
	
	$aquien = $rowAQ[0].' '.$rowAQ[1].' '.$rowAQ[2];
	
	mysql_select_db($database_horizonte, $horizonte);
	$resultCP=mysql_query("SELECT concepto_to from conceptos where id_to = $idConc ", $horizonte) or die (mysql_error());
 	$rowCP = mysql_fetch_row($resultCP);
	
	mysql_select_db($database_horizonte, $horizonte);
	$result1=mysql_query("SELECT fc_sv, fr_sv, concat(t_sv, '/', a_sv), temperatura_sv, peso_sv, talla_sv, imc_sv, cintura_sv, notas_sv,DATE_FORMAT(fecha_sv,'%d/%c/%Y %H:%i:%s') from signos_vitales where id_sv = $idSVC1 ", $horizonte) or die (mysql_error());
 	$row1 = mysql_fetch_row($result1);
	
	$noTC = sqlValue($rowC[0], "text");
	
	switch($rowC[2]){
	 case 1:
	 	$rowC[2]='ENERO';
	 break;
	 case 2:
	 	$rowC[2]='FEBRERO';
	 break;
	 case 3:
	 	$rowC[2]='MARZO';
	 break;
	 case 4:
	 	$rowC[2]='ABRIL';
	 break;
	 case 5:
	 	$rowC[2]='MAYO';
	 break;
	 case 6:
	 	$rowC[2]='JUNIO';
	 break;
	 case 7:
	 	$rowC[2]='JULIO';
	 break;
	 case 8:
	 	$rowC[2]='AGOSTO';
	 break;
	 case 9:
	 	$rowC[2]='SEPTIEMBRE';
	 break;
	 case 10:
	 	$rowC[2]='OCTUBRE';
	 break;
	 case 11:
	 	$rowC[2]='NOVIEMBRE';
	 break;
	 case 12:
	 	$rowC[2]='DICIEMBRE';
	 break;
 }
 $miFecha = $rowC[1]." DE ".$rowC[2]." DEL ".$rowC[3];//." A LAS ".$rowC[5].":".$rowC[6].' HORAS';//.":".$rowC[7];
	
	mysql_select_db($database_horizonte, $horizonte);
	$resultC1 = mysql_query("SELECT nota_interpretacion, referencia_vc from venta_conceptos where id_vc = $idC limit 1", $horizonte) or die (mysql_error());
 	$rowC1 = mysql_fetch_row($resultC1);
	
	$nombre = $row[0].' '.$row[1].' '.$row[2];
	
	mysql_select_db($database_horizonte, $horizonte);
	$resultAl = mysql_query("SELECT alergia1_hc, alergia2_hc, alergia3_hc, alergia4_hc, alergia5_hc, alergia6_hc from historia_clinica where id_paciente_hc = $idP ", $horizonte) or die (mysql_error());
 	$rowAl = mysql_fetch_row($resultAl);
	
	if($rowAl[0]=='' and $rowAl[1]=='' and $rowAl[2]=='' and $rowAl[3]=='' and $rowAl[4]=='' and $rowAl[5]==''){$alergias='NINGUNA';}
	else{
		if($rowAl[0]!=''){$aler = $rowAl[0];}
		if($rowAl[1]!=''){$aler = $aler.','.$rowAl[1];}
		if($rowAl[2]!=''){$aler = $aler.','.$rowAl[2];}
		if($rowAl[3]!=''){$aler = $aler.','.$rowAl[3];}
		if($rowAl[4]!=''){$aler = $aler.','.$rowAl[4];}
		if($rowAl[5]!=''){$aler = $aler.','.$rowAl[5];}
		if($aler[0]==','){$alergias = substr($aler, 1);}else{$alergias = $aler;}
	}
	
	mysql_select_db($database_horizonte, $horizonte); 
 $resultU = mysql_query("SELECT nombre_u, apaterno_u, amaterno_u, sexo_u, cedulaProfesional_u, especialidad_u, cedulaProfesionalE_u, titulo_u from usuarios where id_u = $idDR limit 1", $horizonte) or die (mysql_error());
 $rowU = mysql_fetch_row($resultU); $idEspecialidad = sqlValue($rowU[5], "int");
 
 mysql_select_db($database_horizonte, $horizonte); 
 $resultEsp = mysql_query("SELECT nombre_especialidad from especialidades where id_es = $idEspecialidad limit 1", $horizonte) or die (mysql_error());
 $rowEsp = mysql_fetch_row($resultEsp);
 
 if($rowEsp[0]!='' and $rowEsp[0]!='GENERAL'){ 
 	$doctorcito = $rowU[7].' '.$rowU[0]." ".$rowU[1]." ".$rowU[2]." <br>";
 	$especialidadDR = 'MÉDICO '.$rowEsp[0].' CÉDULA DE ESPECIALIDAD '.$rowU[6]; 
}else{
	$doctorcito = $rowU[7].' '.$rowU[0]." ".$rowU[1]." ".$rowU[2]." <br>CÉDULA PROFESIONAL ".$rowU[4];
	$especialidadDR = '';
}
	$datos = $nombre.';*}-{'.$fx.';*}-{'.$row[4].';*}-{'.$direccionP.';*}-{'.$rowC1[1].';*}-{'.$miFecha.';*}-{'.$row1[0].';*}-{'.$row1[1].';*}-{'.$row1[2].';*}-{'.$row1[3].';*}-{'.$row1[4].';*}-{'.$row1[5].';*}-{'.$row1[6].';*}-{'.$rowC1[0].';*}-{'.$alergias.';*}-{'.$doctorcito.';*}-{'.$especialidadDR.';*}-{'.$idP.';*}-{'.$rowCP[0].';*}-{'.$aquien.';*}-{'.$idAquien1;
	
	echo $datos;
 	//Cerrar conexión a la Base de Datos
 	mysql_close($horizonte);
?>