<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	$idP = sqlValue($_POST["idP"], "int");
	$idE = sqlValue($_POST["idE"], "int");

	mysql_select_db($database_horizonte, $horizonte);
	$result = mysql_query("SELECT nombre_p, apaterno_p, amaterno_p, fNac_p, sexo_p from pacientes where id_p = $idP ", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result); $fx = $row[3];
	
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
		
	$nombre = $row[0].' '.$row[1].' '.$row[2];
		
	$datos = $nombre;
	
	mysql_select_db($database_horizonte, $horizonte);
	$result1 = mysql_query("SELECT hp.estatus_padre_hc, e1.nombre_ef, e2.nombre_ef, e3.nombre_ef, e4.nombre_ef from historia_clinica hp left join enfermedades e1 on e1.id_ef = hp.ahf_padre_1 left join enfermedades e2 on e2.id_ef = hp.ahf_padre_2 left join enfermedades e3 on e3.id_ef = hp.ahf_padre_3 left join enfermedades e4 on e4.id_ef = hp.ahf_padre_4 where hp.id_paciente_hc = $idP ", $horizonte) or die (mysql_error());
 	$row1 = mysql_fetch_row($result1);
	// AHF PADRE
	if( $row1[0]=='' and $row1[1]=='' and $row1[2]=='' and $row1[3]=='' and $row1[4]=='' ){ $dataAHF = 'NORMALES'; }else
	{
		if($row1[0]==1){ $dataAHF = '* PADRE VIVO'; } if($row1[0]==2){ $dataAHF = '* PADRE FINADO'; }
		if( $row1[1]!='' and $row1[2]!='' and $row1[3]!='' and $row1[4]!='' ){
			if($row1[1]!=''){$enfermedadesP = $row1[1];}
			if($row1[2]!=''){$enfermedadesP = $enfermedadesP.', '.$row1[2];}
			if($row1[3]!=''){$enfermedadesP = $enfermedadesP.', '.$row1[3];}
			if($row1[4]!=''){$enfermedadesP = $enfermedadesP.', '.$row1[4];}
			$dataAHF = $dataAHF.', CON LAS SIGUIENTES ENFERMEDADES: '.$enfermedadesP;
		}else{$dataAHF = $dataAHF.', SIN ENFERMEDADES';}
	}
	mysql_select_db($database_horizonte, $horizonte);
	$result2 = mysql_query("SELECT hp.estatus_madre_hc, e1.nombre_ef, e2.nombre_ef, e3.nombre_ef, e4.nombre_ef from historia_clinica hp left join enfermedades e1 on e1.id_ef = hp.ahf_madre_1 left join enfermedades e2 on e2.id_ef = hp.ahf_madre_2 left join enfermedades e3 on e3.id_ef = hp.ahf_madre_3 left join enfermedades e4 on e4.id_ef = hp.ahf_madre_4 where hp.id_paciente_hc = $idP ", $horizonte) or die (mysql_error());
 	$row2 = mysql_fetch_row($result2);
	// AHF MADRE
	if( $row2[0]=='' and $row2[1]=='' and $row2[2]=='' and $row2[3]=='' and $row2[4]=='' ){ $dataAHF1 = 'NORMALES'; }else
	{
		if($row2[0]==1){ $dataAHF1 = '* MADRE VIVA'; } if($row2[0]==2){ $dataAHF1 = '* MADRE FINADA'; }
		if( $row2[1]!='' and $row2[2]!='' and $row2[3]!='' and $row2[4]!='' ){
			if($row2[1]!=''){$enfermedadesM = $row2[1];}
			if($row2[2]!=''){$enfermedadesM = $enfermedadesM.', '.$row2[2];}
			if($row2[3]!=''){$enfermedadesM = $enfermedadesM.', '.$row2[3];}
			if($row2[4]!=''){$enfermedadesM = $enfermedadesM.', '.$row2[4];}
			$dataAHF1 = $dataAHF1.', CON LAS SIGUIENTES ENFERMEDADES: '.$enfermedadesM;
		}else{$dataAHF1 = $dataAHF1.', SIN ENFERMEDADES';}
	}
	mysql_select_db($database_horizonte, $horizonte);
	$result3 = mysql_query("SELECT hp.no_hermanos, e1.nombre_ef, e2.nombre_ef, e3.nombre_ef, e4.nombre_ef from historia_clinica hp left join enfermedades e1 on e1.id_ef = hp.ahf_hnos_1 left join enfermedades e2 on e2.id_ef = hp.ahf_hnos_2 left join enfermedades e3 on e3.id_ef = hp.ahf_hnos_3 left join enfermedades e4 on e4.id_ef = hp.ahf_hnos_4 where hp.id_paciente_hc = $idP ", $horizonte) or die (mysql_error());
 	$row3 = mysql_fetch_row($result3);
	// AHF HNOS
	if( $row3[0]=='' and $row3[1]=='' and $row3[2]=='' and $row3[3]=='' and $row3[4]=='' ){ $dataAHF2 = 'NORMALES'; }else
	{
		if($row3[0]=='' or $row3[0]==0){ $dataAHF2 = '* SIN HERMANOS'; } else{ $dataAHF2 = '* NÚMERO DE HERMANOS: '.$row3[0].' '; }
		if( $row3[1]!='' and $row3[2]!='' and $row3[3]!='' and $row3[4]!='' ){
			if($row3[1]!=''){$enfermedadesH = $row3[1];}
			if($row3[2]!=''){$enfermedadesH = $enfermedadesH.', '.$row3[2];}
			if($row3[3]!=''){$enfermedadesH = $enfermedadesH.', '.$row3[3];}
			if($row3[4]!=''){$enfermedadesH = $enfermedadesH.', '.$row3[4];}
			$dataAHF2 = $dataAHF2.', CON LAS SIGUIENTES ENFERMEDADES: '.$enfermedadesH;
		}else{if($row3[0]=='' or $row3[0]==0){} else{$dataAHF2 = $dataAHF2.', SIN ENFERMEDADES';} }
	}
	mysql_select_db($database_horizonte, $horizonte);
	$result4 = mysql_query("SELECT hp.estatus_conyugue, e1.nombre_ef, e2.nombre_ef, e3.nombre_ef, e4.nombre_ef from historia_clinica hp left join enfermedades e1 on e1.id_ef = hp.ahf_conyugue_1 left join enfermedades e2 on e2.id_ef = hp.ahf_conyugue_2 left join enfermedades e3 on e3.id_ef = hp.ahf_conyugue_3 left join enfermedades e4 on e4.id_ef = hp.ahf_conyugue_4 where hp.id_paciente_hc = $idP ", $horizonte) or die (mysql_error());
 	$row4 = mysql_fetch_row($result4);
	// AHF Conyugue
	if( $row4[0]=='' and $row4[1]=='' and $row4[2]=='' and $row4[3]=='' and $row4[4]=='' ){ $dataAHF3 = 'NORMALES'; }else
	{
		if($row4[0]==1){ $dataAHF3 = '* CONYUGUE VIVO(A)'; } if($row4[0]==2){ $dataAHF3 = '* CONYUGUE FINADO(A)'; }
		if( $row4[1]!='' and $row4[2]!='' and $row4[3]!='' and $row4[4]!='' ){
			if($row4[1]!=''){$enfermedadesC = $row4[1];}
			if($row4[2]!=''){$enfermedadesC = $enfermedadesC.', '.$row4[2];}
			if($row4[3]!=''){$enfermedadesC = $enfermedadesC.', '.$row4[3];}
			if($row4[4]!=''){$enfermedadesC = $enfermedadesC.', '.$row4[4];}
			$dataAHF3 = $dataAHF3.', CON LAS SIGUIENTES ENFERMEDADES: '.$enfermedadesC;
		}else{$dataAHF3 = $dataAHF3.', SIN ENFERMEDADES';}
	}
	mysql_select_db($database_horizonte, $horizonte);
	$result5 = mysql_query("SELECT hp.no_hijos_hc, e1.nombre_ef, e2.nombre_ef, e3.nombre_ef, e4.nombre_ef from historia_clinica hp left join enfermedades e1 on e1.id_ef = hp.ahf_hijos_1 left join enfermedades e2 on e2.id_ef = hp.ahf_hijos_2 left join enfermedades e3 on e3.id_ef = hp.ahf_hijos_3 left join enfermedades e4 on e4.id_ef = hp.ahf_hijos_4 where hp.id_paciente_hc = $idP ", $horizonte) or die (mysql_error());
 	$row5 = mysql_fetch_row($result5);
	// AHF HNOS
	if( $row5[0]=='' and $row5[1]=='' and $row5[2]=='' and $row5[3]=='' and $row5[4]=='' ){ $dataAHF4 = 'NORMALES'; }else
	{
		if($row5[0]=='' or $row5[0]==0){ $dataAHF4 = '* SIN HIJOS'; } else{ $dataAHF4 = '* NÚMERO DE HIJOS: '.$row5[0].' '; }
		if( $row5[1]!='' and $row5[2]!='' and $row5[3]!='' and $row5[4]!='' ){
			if($row5[1]!=''){$enfermedadesHi = $row5[1];}
			if($row5[2]!=''){$enfermedadesHi = $enfermedadesHi.', '.$row5[2];}
			if($row5[3]!=''){$enfermedadesHi = $enfermedadesHi.', '.$row5[3];}
			if($row5[4]!=''){$enfermedadesHi = $enfermedadesHi.', '.$row5[4];}
			$dataAHF4 = $dataAHF4.', CON LAS SIGUIENTES ENFERMEDADES: '.$enfermedadesHi;
		}else{if($row5[0]=='' or $row5[0]==0){ }else{$dataAHF4 = $dataAHF4.', SIN ENFERMEDADES';} }
	}
	mysql_select_db($database_horizonte, $horizonte);
	$result6 = mysql_query("SELECT hp.ahf_notas from historia_clinica hp where hp.id_paciente_hc = $idP ", $horizonte) or die (mysql_error());
 	$row6 = mysql_fetch_row($result6);
	// AHF NOTAS AHF
	if( $row6[0]=='' ){ $dataAHF5 = ''; }else { $dataAHF5 = '* NOTAS: '.$row6[0]; }
	
	mysql_select_db($database_horizonte, $horizonte);
	$result7 = mysql_query("SELECT a1.adiccion_ca, a2.adiccion_ca, a3.adiccion_ca, c1.inicio_ci, c2.inicio_ci, c3.inicio_ci, f1.frecuencia_cf, f2.frecuencia_cf, f3.frecuencia_cf, d1.deporte_dp, d2.deporte_dp, fd1.frecuencia_cf, fd2.frecuencia_cf, r1.recreacion_cr, r2.recreacion_cr, hp.apnp_notas from historia_clinica hp left join catalogo_adicciones a1 on a1.id_ca = hp.adiccion1 left join catalogo_adicciones a2 on a2.id_ca = hp.adiccion2 left join catalogo_adicciones a3 on a3.id_ca = hp.adiccion3 left join catalogo_inicios c1 on c1.id_ci = hp.inicio_adiccion1 left join catalogo_inicios c2 on c2.id_ci = hp.inicio_adiccion2 left join catalogo_inicios c3 on c3.id_ci = hp.inicio_adiccion3 left join catalogo_frecuencias f1 on f1.if_cf = hp.frecuencia_adiccion1 left join catalogo_frecuencias f2 on f2.if_cf = hp.frecuencia_adiccion2 left join catalogo_frecuencias f3 on f3.if_cf = hp.frecuencia_adiccion3 left join deportes d1 on d1.id_dp = hp.deporte1 left join deportes d2 on d2.id_dp = hp.deporte2 left join catalogo_frecuencias fd1 on fd1.if_cf = hp.frecuencia_deporte1 left join catalogo_frecuencias fd2 on fd2.if_cf = hp.frecuencia_deporte2 left join catalogo_recreaciones r1 on r1.id_cr = hp.recreacion1 left join catalogo_recreaciones r2 on r2.id_cr = hp.recreacion2 where hp.id_paciente_hc = $idP ", $horizonte) or die (mysql_error());
 	$row7 = mysql_fetch_row($result7);
	// APNP Adicciones
	if( $row7[0]=='' and $row7[1]=='' and $row7[2]=='' ){ $dataAHF6 = '* SIN ADICCIONES'; }
	else{
		if($row7[0]!=''){
			$adiccion1 = $row7[0];
			if($row7[3]!=''){$adiccion1 = $adiccion1.' '.$row7[3];}
			if($row7[6]!=''){$adiccion1 = $adiccion1.' CON UNA FRECUENCIA '.$row7[6];}
			$dataAHF6 = $adiccion1;
		}
		if($row7[1]!=''){
			$adiccion2 = $row7[1];
			if($row7[4]!=''){$adiccion2 = $adiccion2.' '.$row7[4];}
			if($row7[7]!=''){$adiccion2 = $adiccion2.' CON UNA FRECUENCIA '.$row7[7];}
			$dataAHF6 = $dataAHF6.', '.$adiccion2;
		}
		if($row7[2]!=''){
			$adiccion3 = $row7[2];
			if($row7[5]!=''){$adiccion3 = $adiccion3.' '.$row7[5];}
			if($row7[8]!=''){$adiccion3 = $adiccion3.' CON UNA FRECUENCIA '.$row7[8];}
			$dataAHF6 = $dataAHF6.', '.$adiccion3;
		}
		$dataAHF6 = '* CON LAS SIGUIENTES ADICCIONES: '.$dataAHF6;
	}
	// APNP Deportes
	if( $row7[9]=='' and $row7[10]=='' ){ $dataAHF7 = '* SIN PRÁCTICA DE DEPORTES'; }
	else{
		if($row7[9]!=''){
			$deporte1 = $row7[9];
			if($row7[11]!=''){$deporte1 = $deporte1.' CON UNA FRECUENCIA '.$row7[11];}
			$dataAHF7 = $deporte1;
		}
		if($row7[10]!=''){
			$deporte2 = $row7[10];
			if($row7[12]!=''){$deporte2 = $deporte2.' CON UNA FRECUENCIA '.$row7[12];}
			$dataAHF7 = $dataAHF7.', '.$deporte2;
		}
		$dataAHF7 = '* PRACTICA LOS SIGUIENTES DEPORTES: '.$dataAHF7;
	}
	// APNP Deportes
	if( $row7[13]=='' and $row7[14]=='' ){ $dataAHF8 = '* SIN ACTIVIDADES DE RECREACIÓN'; }
	else{
		if($row7[13]!=''){
			$recreacion1 = $row7[13];
			$dataAHF8 = $recreacion1;
		}
		if($row7[14]!=''){
			$recreacion2 = $row7[14];
			$dataAHF8 = $dataAHF8.', '.$recreacion2;
		}
		$dataAHF8 = '* PRACTICA LAS SIGUIENTES ACTIVIDADES RECREATICAS: '.$dataAHF8;
	}
	// AHF NOTAS AHF
	if( $row7[15]=='' ){ $dataAHF9 = ''; }else { $dataAHF9 = '* NOTAS: '.$row7[15]; }
	
	mysql_select_db($database_horizonte, $horizonte);
	$result8 = mysql_query("SELECT hp.alergia1_hc, hp.alergia2_hc, hp.alergia3_hc, hp.alergia4_hc, hp.alergia5_hc, hp.alergia6_hc, hp.cirugia1, hp.cirugia2, hp.cirugia3, hp.transfusiones_hc, hp.app_notas from historia_clinica hp where hp.id_paciente_hc = $idP ", $horizonte) or die (mysql_error());
 	$row8 = mysql_fetch_row($result8);
	// APP ALERGIAS
	if( $row8[0]=='' and $row8[1]=='' and $row8[2]=='' and $row8[3]=='' and $row8[4]=='' and $row8[5]=='' ){ $dataAHF10 = '* SIN ALÉRGIAS'; }else { 
		$dataAHF10 = '* ALÉRGIAS: '.$row8[0];
		if($row8[1]!=''){ $dataAHF10 = $dataAHF10.', '.$row8[1];}
		if($row8[2]!=''){ $dataAHF10 = $dataAHF10.', '.$row8[2];}
		if($row8[3]!=''){ $dataAHF10 = $dataAHF10.', '.$row8[3];}
		if($row8[4]!=''){ $dataAHF10 = $dataAHF10.', '.$row8[4];}
		if($row8[5]!=''){ $dataAHF10 = $dataAHF10.', '.$row8[5];}
	}
	//APP Cirugías
	if( $row8[6]=='' and $row8[7]=='' and $row8[8]=='' ){ $dataAHF11 = '* SIN CIRUGÍAS'; }else { 
		$dataAHF11 = '* CIRUGÍAS: '.$row8[6];
		if($row8[7]!=''){ $dataAHF11 = $dataAHF11.', '.$row8[7];}
		if($row8[8]!=''){ $dataAHF11 = $dataAHF11.', '.$row8[8];}
	}
	//APP Transfusiones
	if( $row8[9]=='' or $row8[9]==0 ){ $dataAHF12 = '* SIN TRANSFUSIONES'; }else { 
		$dataAHF12 = '* TRANSFUSIONES: '.$row8[9];
	}
	// APP NOTAS 
	if( $row8[10]=='' ){ $dataAHF13 = ''; }else { $dataAHF13 = '* NOTAS: '.$row8[10]; }
	
	mysql_select_db($database_horizonte, $horizonte);
	$result9 = mysql_query("SELECT hp.menarca_hc, hp.ritmo_hc, hp.duracion_hc, hp.fur_hc, hp.ivsa_hc, hp.gestas_hc, hp.partos_hc, hp.cesareas_hc, hp.abortos_hc, hp.anticonceptivo_hc, a.anticonceptivo_at, hp.tiempo_uso_hc, hp.ago_notas_hc from historia_clinica hp left join catalogo_anticonceptivos a on a.id_at = hp.tipo_anticonceptivo_hc where hp.id_paciente_hc = $idP ", $horizonte) or die (mysql_error());
 	$row9 = mysql_fetch_row($result9);
	// AGO 
	if( $row9[0]!='' ){ $dataAHF14 = '* EDAD DE MENARCA: '.$row9[0].' AÑOS, '; }
	if($row9[1]!=''){ if($row9[1]==1){$r='REGULAR';}else{$r='IRREGULAR';}$dataAHF14 = $dataAHF14.'RITMO MENSTRUAL: '.$r.', ';}
	if($row9[2]!=''){ $dataAHF14 = $dataAHF14.'DURACIÓN DE LA REGLA: '.$row9[2].' DÍAS, ';}
	if($row9[3]!=''){ $dataAHF14 = $dataAHF14.'FECHA DE LA ÚLTIMA REGLA: '.$row9[3].', ';}
	if($row9[4]!=''){ $dataAHF14 = $dataAHF14.'INICIACIÓN A LA VIDA SEXUAL ACTIVA A LOS '.$row9[4].' AÑOS, ';}
	if($row9[5]!=''){ $dataAHF14 = $dataAHF14.'NÚMERO DE GESTAS: '.$row9[5].', ';}
	if($row9[6]!='' and $row9[6]!=0){ $dataAHF14 = $dataAHF14.'NÚMERO DE PARTOS: '.$row9[6].', ';}
	if($row9[7]!='' and $row9[7]!=0){ $dataAHF14 = $dataAHF14.'NÚMERO DE CESAREAS: '.$row9[7].', ';}
	if($row9[8]!='' and $row9[8]!=0){ $dataAHF14 = $dataAHF14.'NÚMERO DE ABORTOS: '.$row9[8].', ';}
	if($row9[9]==1 ){ 
		if($row9[10]!='' ){
			if($row9[11]!='' and $row9[11]!=0 ){ $duranteA = ' DURANTE '.$row9[11].' AÑOS'; }
			$dataAHF14 = $dataAHF14.'ANTICONCEPTIVO USADO: '.$row9[10].$duranteA; 
		}
	}
	if($row9[12]!=''){ $dataAHF15 = '* NOTAS: '.$row9[12];}

	$hc="<table width='100%' height='100%' border='0' cellspacing='0' cellpadding='4'> <tr> <td valign='top' id='h_ahf'><span style='text-decoration:underline;'>ANTECEDENTES HEREDO FAMILIARES</span>: <br><br>&nbsp;&nbsp;&nbsp;&nbsp;".$dataAHF."<br>&nbsp;&nbsp;&nbsp;&nbsp;".$dataAHF1."<br>&nbsp;&nbsp;&nbsp;&nbsp;".$dataAHF2."<br>&nbsp;&nbsp;&nbsp;&nbsp;".$dataAHF3."<br>&nbsp;&nbsp;&nbsp;&nbsp;".$dataAHF4."<br>&nbsp;&nbsp;&nbsp;&nbsp;".$dataAHF5."</td> </tr> <tr> <td valign='top' id='h_apnp'><span style='text-decoration:underline;'>ANTECEDENTES PATOLÓGICOS NO PERSONALES</span>: <br><br>&nbsp;&nbsp;&nbsp;&nbsp;".$dataAHF6."<br>&nbsp;&nbsp;&nbsp;&nbsp;".$dataAHF7."<br>&nbsp;&nbsp;&nbsp;&nbsp;".$dataAHF8."<br>&nbsp;&nbsp;&nbsp;&nbsp;".$dataAHF9."</td> </tr> <tr> <td valign='top' id='h_app'><span style='text-decoration:underline;'>ANTECEDENTES PATOLÓGICOS PERSONALES</span>: <br><br>&nbsp;&nbsp;&nbsp;&nbsp;".$dataAHF10."<br>&nbsp;&nbsp;&nbsp;&nbsp;".$dataAHF11."<br>&nbsp;&nbsp;&nbsp;&nbsp;".$dataAHF12."</td> </tr> <tr> <td valign='top' id='h_ago'><span style='text-decoration:underline;'>ANTECEDENTES GINECO-OBSTÉTRICOS</span>: <br><br>&nbsp;&nbsp;&nbsp;&nbsp;".$dataAHF14."<br>&nbsp;&nbsp;&nbsp;&nbsp;".$dataAHF15."</td> </tr> </table>";
		
	mysql_select_db($database_horizonte, $horizonte);// para lab
	$result1d = mysql_query("SELECT v.id_vc, c.concepto_to from venta_conceptos v left join conceptos c on c.id_to = v.id_concepto_es where v.id_paciente_vc = $idP and v.temporal_vc = 0 and v.tipo_concepto_vc = 3 and v.estatus_vc > 6 and c.concepto_to!='' order by v.id_vc desc limit 1 ", $horizonte) or die (mysql_error());
 	$row1d = mysql_fetch_row($result1d);
	
	mysql_select_db($database_horizonte, $horizonte); //Para el primer USG
	$result1w = mysql_query("SELECT id_vc from venta_conceptos left join conceptos on id_to = id_concepto_es where id_paciente_vc = $idP and temporal_vc = 0 and tipo_concepto_vc = 4 and estatus_vc = 5 and concepto_to != '' and area_vc = 58 order by id_vc desc limit 1 ", $horizonte) or die (mysql_error());
 	$row1w = mysql_fetch_row($result1w);
	
	mysql_select_db($database_horizonte, $horizonte); //Para la primer consulta
	$result1c = mysql_query("SELECT id_vc from venta_conceptos left join conceptos on id_to = id_concepto_es where id_vc < $idE and id_paciente_vc = $idP and tipo_concepto_vc = 1 and estatus_vc = 6 and concepto_to != '' and temporal_vc = 0 order by fecha_venta_vc desc limit 1 ", $horizonte) or die (mysql_error());
 	$row1c = mysql_fetch_row($result1c);
	
	mysql_select_db($database_horizonte, $horizonte); //Para la primer servicios
	$result1s = mysql_query("SELECT id_vc from venta_conceptos left join conceptos on id_to = id_concepto_es where id_vc > $idE and id_paciente_vc = $idP and tipo_concepto_vc = 2 and estatus_vc = 5 and concepto_to != '' order by id_vc desc limit 1 ", $horizonte) or die (mysql_error());
 	$row1s = mysql_fetch_row($result1s);
	
	mysql_select_db($database_horizonte, $horizonte); //Para el primer img
	$result1i = mysql_query("SELECT id_vc from venta_conceptos left join conceptos on id_to = id_concepto_es where id_paciente_vc = $idP and tipo_concepto_vc = 4 and estatus_vc = 5 and concepto_to != '' and area_vc not in (29,58,85) and temporal_vc = 0 order by id_vc desc limit 1 ", $horizonte) or die (mysql_error());
 	$row1i = mysql_fetch_row($result1i);
	
	mysql_select_db($database_horizonte, $horizonte); //Para el primer endo
	$result1e = mysql_query("SELECT id_vc from venta_conceptos left join conceptos on id_to = id_concepto_es where id_paciente_vc = $idP and tipo_concepto_vc = 4 and estatus_vc = 5 and concepto_to != '' and area_vc = 29 and temporal_vc = 0 order by id_vc asc limit 1 ", $horizonte) or die (mysql_error());
 	$row1e = mysql_fetch_row($result1e);
	
	mysql_select_db($database_horizonte, $horizonte); //Para el primer colpo
	$result1cl = mysql_query("SELECT id_vc from venta_conceptos left join conceptos on id_to = id_concepto_es where id_paciente_vc = $idP and tipo_concepto_vc = 4 and estatus_vc = 5 and concepto_to != '' and area_vc = 85 and temporal_vc = 0 order by id_vc desc limit 1 ", $horizonte) or die (mysql_error());
 	$row1cl = mysql_fetch_row($result1cl);
	
	echo $datos.'*;'.$fx.'*;'.$row[4].'*;'.$hc.'*;'.$row1d[0].'*;'.$row1d[1].'*;'.$row1w[0].'*;'.$row1c[0].'*;'.$row1s[0].'*;'.$row1i[0].'*;'.$row1e[0].'*;'.$row1cl[0];
 	//Cerrar conexión a la Base de Datos
 	mysql_close($horizonte);
?>