<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	$idP = sqlValue($_POST["idP"], "int"); $idE = sqlValue($_POST["idE"], "int");

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
		case 1: $row[4] = "FEMENINO"; break; case 2: $row[4] = "MASCULINO"; break;
		case 3: $row[4] = "AMBIGUO"; break; case 4: $row[4] = "NO APLICA"; break; case 99: $row[4] = "SIN ASIGNACIÓN"; break;
	}
		
	$nombre = $row[0].' '.$row[1].' '.$row[2];
	$datos = $nombre;
	
	// AHF PADRE
	mysql_select_db($database_horizonte, $horizonte);
	$result1 = mysql_query("SELECT hp.estatus_padre_hc, e1.nombre_ef, e2.nombre_ef, e3.nombre_ef, e4.nombre_ef from historia_clinica hp left join enfermedades e1 on e1.id_ef = hp.ahf_padre_1 left join enfermedades e2 on e2.id_ef = hp.ahf_padre_2 left join enfermedades e3 on e3.id_ef = hp.ahf_padre_3 left join enfermedades e4 on e4.id_ef = hp.ahf_padre_4 where hp.id_paciente_hc = $idP order by id_hc desc limit 1", $horizonte) or die (mysql_error());
 	$row1 = mysql_fetch_row($result1);
	//Estatus del padre:
	if( $row1[0]!==''){ if($row1[0]==1){ $estatus_padre1 = 'VIVO'; }else{ $estatus_padre1 = 'FINADO'; } }
	else{$estatus_padre1 = 'INFORMACIÓN NO PROPORCIONADA';}
	//Enfermedades del padre:
	if( $row1[1]!='' and $row1[2]!='' and $row1[3]!='' and $row1[4]!='' ){
		if($row1[1]!=''){$enfermedadesP = $row1[1];}
		if($row1[2]!=''){$enfermedadesP = $enfermedadesP.', '.$row1[2];}
		if($row1[3]!=''){$enfermedadesP = $enfermedadesP.', '.$row1[3];}
		if($row1[4]!=''){$enfermedadesP = $enfermedadesP.', '.$row1[4];}
		$dataAHF = $enfermedadesP;
	}else{$dataAHF = 'NINGUNA ESPECIFICADA';}
	
	//AHF MADRE
	mysql_select_db($database_horizonte, $horizonte);
	$result2 = mysql_query("SELECT hp.estatus_madre_hc, e1.nombre_ef, e2.nombre_ef, e3.nombre_ef, e4.nombre_ef from historia_clinica hp left join enfermedades e1 on e1.id_ef = hp.ahf_madre_1 left join enfermedades e2 on e2.id_ef = hp.ahf_madre_2 left join enfermedades e3 on e3.id_ef = hp.ahf_madre_3 left join enfermedades e4 on e4.id_ef = hp.ahf_madre_4 where hp.id_paciente_hc = $idP order by id_hc desc limit 1", $horizonte) or die (mysql_error());
 	$row2 = mysql_fetch_row($result2);
	//Estatus de la madre:
	if( $row2[0]!==''){ if($row2[0]==1){ $estatus_madre1 = 'VIVA'; }else{ $estatus_madre1 = 'FINADA'; } }
	else{$estatus_padre1 = 'INFORMACIÓN NO PROPORCIONADA';}
	//Enfermedades de la madre:
	if( $row2[1]!='' and $row2[2]!='' and $row2[3]!='' and $row2[4]!='' ){
		if($row2[1]!=''){$enfermedadesM = $row2[1];}
		if($row2[2]!=''){$enfermedadesM = $enfermedadesM.', '.$row2[2];}
		if($row2[3]!=''){$enfermedadesM = $enfermedadesM.', '.$row2[3];}
		if($row2[4]!=''){$enfermedadesM = $enfermedadesM.', '.$row2[4];}
		$dataAHF1 = $enfermedadesM;
	}else{$dataAHF1 = 'NINGUNA ESPECIFICADA';}
	
	// AHF Conyugue
	mysql_select_db($database_horizonte, $horizonte);
	$result4 = mysql_query("SELECT hp.estatus_conyugue, e1.nombre_ef, e2.nombre_ef, e3.nombre_ef, e4.nombre_ef from historia_clinica hp left join enfermedades e1 on e1.id_ef = hp.ahf_conyugue_1 left join enfermedades e2 on e2.id_ef = hp.ahf_conyugue_2 left join enfermedades e3 on e3.id_ef = hp.ahf_conyugue_3 left join enfermedades e4 on e4.id_ef = hp.ahf_conyugue_4 where hp.id_paciente_hc = $idP order by id_hc desc limit 1", $horizonte) or die (mysql_error());
 	$row4 = mysql_fetch_row($result4);
	//Estatus del conyugue:
	if( $row4[0]!==''){ if($row4[0]==1){ $estatus_conyugue1 = 'VIVA'; }else{ $estatus_conyugue1 = 'FINADA'; } }
	else{$estatus_conyugue1 = 'INFORMACIÓN NO PROPORCIONADA';}
	//Enfermedades del conyugue:
	if( $row4[1]!='' and $row4[2]!='' and $row4[3]!='' and $row4[4]!='' ){
		if($row4[1]!=''){$enfermedadesC = $row4[1];}
		if($row4[2]!=''){$enfermedadesC = $enfermedadesC.', '.$row4[2];}
		if($row4[3]!=''){$enfermedadesC = $enfermedadesC.', '.$row4[3];}
		if($row4[4]!=''){$enfermedadesC = $enfermedadesC.', '.$row4[4];}
		$dataAHF3 = $enfermedadesC;
	}else{$dataAHF3 = 'NINGUNA ESPECIFICADA';}
	
	// AHF HNOS
	mysql_select_db($database_horizonte, $horizonte);
	$result3 = mysql_query("SELECT hp.no_hermanos, e1.nombre_ef, e2.nombre_ef, e3.nombre_ef, e4.nombre_ef from historia_clinica hp left join enfermedades e1 on e1.id_ef = hp.ahf_hnos_1 left join enfermedades e2 on e2.id_ef = hp.ahf_hnos_2 left join enfermedades e3 on e3.id_ef = hp.ahf_hnos_3 left join enfermedades e4 on e4.id_ef = hp.ahf_hnos_4 where hp.id_paciente_hc = $idP order by id_hc desc limit 1", $horizonte) or die (mysql_error());
 	$row3 = mysql_fetch_row($result3);
	//Cantidad de hermanos:
	if( $row3[0]!==''){ $cantidad_hermanos = $row3[0]; }
	else{$cantidad_hermanos = 'INFORMACIÓN NO PROPORCIONADA';}
	//Enfermedades de hermanos
	if( $row3[1]!='' and $row3[2]!='' and $row3[3]!='' and $row3[4]!='' ){
		if($row3[1]!=''){$enfermedadesH = $row3[1];}
		if($row3[2]!=''){$enfermedadesH = $enfermedadesH.', '.$row3[2];}
		if($row3[3]!=''){$enfermedadesH = $enfermedadesH.', '.$row3[3];}
		if($row3[4]!=''){$enfermedadesH = $enfermedadesH.', '.$row3[4];}
		$dataAHF2 = $enfermedadesH;
	}else{$dataAHF2 = 'NINGUNA ESPECIFICADA'; }
	
	// AHF HIJOS
	mysql_select_db($database_horizonte, $horizonte);
	$result5 = mysql_query("SELECT hp.no_hijos_hc, e1.nombre_ef, e2.nombre_ef, e3.nombre_ef, e4.nombre_ef from historia_clinica hp left join enfermedades e1 on e1.id_ef = hp.ahf_hijos_1 left join enfermedades e2 on e2.id_ef = hp.ahf_hijos_2 left join enfermedades e3 on e3.id_ef = hp.ahf_hijos_3 left join enfermedades e4 on e4.id_ef = hp.ahf_hijos_4 where hp.id_paciente_hc = $idP order by id_hc desc limit 1", $horizonte) or die (mysql_error());
 	$row5 = mysql_fetch_row($result5);
	//Cantidad de hijos:
	if( $row5[0]!==''){ $cantidad_hijos = $row5[0]; }
	else{$cantidad_hijos = 'INFORMACIÓN NO PROPORCIONADA';}
	//Enfermedades de hijos
	if( $row5[1]!='' and $row5[2]!='' and $row5[3]!='' and $row5[4]!='' ){
		if($row5[1]!=''){$enfermedadesHi = $row5[1];}
		if($row5[2]!=''){$enfermedadesHi = $enfermedadesHi.', '.$row5[2];}
		if($row5[3]!=''){$enfermedadesHi = $enfermedadesHi.', '.$row5[3];}
		if($row5[4]!=''){$enfermedadesHi = $enfermedadesHi.', '.$row5[4];}
		$dataAHF4 = $enfermedadesHi;
	}else{$dataAHF4 = 'NINGUNA ESPECIFICADA';}
	
	// AHF NOTAS AHF
	mysql_select_db($database_horizonte, $horizonte);
	$result6 = mysql_query("SELECT hp.ahf_notas from historia_clinica hp where hp.id_paciente_hc = $idP order by id_hc desc limit 1", $horizonte) or die (mysql_error());
 	$row6 = mysql_fetch_row($result6);
	if( $row6[0]=='' ){ $dataAHF5 = 'SIN NOTAS'; }else { $dataAHF5 = $row6[0]; }
	
	mysql_select_db($database_horizonte, $horizonte);
	$result7 = mysql_query("SELECT a1.adiccion_ca, a2.adiccion_ca, a3.adiccion_ca, c1.inicio_ci, c2.inicio_ci, c3.inicio_ci, f1.frecuencia_cf, f2.frecuencia_cf, f3.frecuencia_cf, d1.deporte_dp, d2.deporte_dp, fd1.frecuencia_cf, fd2.frecuencia_cf, r1.recreacion_cr, r2.recreacion_cr, hp.apnp_notas, d3.deporte_dp, fd3.frecuencia_cf, r3.recreacion_cr, ap.aseo_ap, ta.alimentacion_ta, hp.horas_dormir_hc, cv.concepto_vivienda, hp.habitantes_hc, mv.material_mv, cs1.servicio_cs, cs2.servicio_cs, cs3.servicio_cs, cs4.servicio_cs, cs5.servicio_cs, cm1.mascota_cm, cm2.mascota_cm, cm3.mascota_cm, cm4.mascota_cm, cm5.mascota_cm, e1.nombre_ef, e2.nombre_ef, e3.nombre_ef, e4.nombre_ef, e5.nombre_ef from historia_clinica hp left join catalogo_adicciones a1 on a1.id_ca = hp.adiccion1 left join catalogo_adicciones a2 on a2.id_ca = hp.adiccion2 left join catalogo_adicciones a3 on a3.id_ca = hp.adiccion3 left join catalogo_inicios c1 on c1.id_ci = hp.inicio_adiccion1 left join catalogo_inicios c2 on c2.id_ci = hp.inicio_adiccion2 left join catalogo_inicios c3 on c3.id_ci = hp.inicio_adiccion3 left join catalogo_frecuencias f1 on f1.if_cf = hp.frecuencia_adiccion1 left join catalogo_frecuencias f2 on f2.if_cf = hp.frecuencia_adiccion2 left join catalogo_frecuencias f3 on f3.if_cf = hp.frecuencia_adiccion3 left join deportes d1 on d1.id_dp = hp.deporte1 left join deportes d2 on d2.id_dp = hp.deporte2 left join catalogo_frecuencias fd1 on fd1.if_cf = hp.frecuencia_deporte1 left join catalogo_frecuencias fd2 on fd2.if_cf = hp.frecuencia_deporte2 left join catalogo_recreaciones r1 on r1.id_cr = hp.recreacion1 left join catalogo_recreaciones r2 on r2.id_cr = hp.recreacion2 left join deportes d3 on d3.id_dp = hp.deporte3 left join catalogo_frecuencias fd3 on fd3.if_cf = hp.frecuencia_deporte3 left join catalogo_recreaciones r3 on r3.id_cr = hp.recreacion3 left join catalogo_aseo_personal ap on ap.id_ap = hp.aseo_personal_hc left join catalogo_tipo_alimentacion ta on ta.id_ta = hp.alimentacion_hc left join catalogo_vivienda cv on cv.id_vivienda = hp.vivienda_hc left join catalogo_maerial_vivienda mv on mv.id_mv = hp.mat_vivienda1 left join catalogo_servicios cs1 on cs1.id_cs = hp.servicios1 left join catalogo_servicios cs2 on cs2.id_cs = hp.servicios2 left join catalogo_servicios cs3 on cs3.id_cs = hp.servicios3 left join catalogo_servicios cs4 on cs4.id_cs = hp.servicios4 left join catalogo_servicios cs5 on cs5.id_cs = hp.servicios5 left join catalogo_mascotas cm1 on cm1.id_cm = hp.mascotas1_hc left join catalogo_mascotas cm2 on cm2.id_cm = hp.mascotas2_hc left join catalogo_mascotas cm3 on cm3.id_cm = hp.mascotas3_hc left join catalogo_mascotas cm4 on cm4.id_cm = hp.mascotas4_hc left join catalogo_mascotas cm5 on cm5.id_cm = hp.mascotas5_hc left join enfermedades e1 on e1.id_ef = hp.enfermedad1 left join enfermedades e2 on e2.id_ef = hp.enfermedad2 left join enfermedades e3 on e3.id_ef = hp.enfermedad3 left join enfermedades e4 on e4.id_ef = hp.enfermedad4 left join enfermedades e5 on e5.id_ef = hp.enfermedad5 where hp.id_paciente_hc = $idP order by id_hc desc limit 1", $horizonte) or die (mysql_error());
	
 	$row7 = mysql_fetch_row($result7);
	//Servicios en casa
	if($row7[25]=='' and $row7[26]=='' and $row7[27]=='' and $row7[28]=='' and $row7[29]==''){
		$servicios = 'INFORMACIÓN NO PROPORCIONADA'; 
	}else{
		if($row7[25]!=''){ $servicios1 = $row7[25]; $servicios = $servicios1; }
		if($row7[26]!=''){ $servicios2 = $row7[26]; $servicios = $servicios1.', '.$servicios2; }
		if($row7[27]!=''){ $servicios3 = $row7[27]; $servicios = $servicios1.', '.$servicios2.', '.$servicios3; }
		if($row7[28]!=''){ $servicios4 = $row7[28]; $servicios = $servicios1.', '.$servicios2.', '.$servicios3.', '.$servicios4; }
		if($row7[29]!=''){ $servicios5 = $row7[29]; $servicios = $servicios1.', '.$servicios2.', '.$servicios3.', '.$servicios4.', '.$servicios5; }
	}
	//Mascotas en casa
	if($row7[30]=='' and $row7[31]=='' and $row7[32]=='' and $row7[33]=='' and $row7[34]==''){
		$mascotas = 'INFORMACIÓN NO PROPORCIONADA'; 
	}else{
		if($row7[30]!=''){ $mascotas1 = $row7[30]; $mascotas = $mascotas1; }
		if($row7[31]!=''){ $mascotas2 = $row7[31]; $mascotas = $mascotas1.', '.$mascotas2; }
		if($row7[32]!=''){ $mascotas3 = $row7[32]; $mascotas = $mascotas1.', '.$mascotas2.', '.$mascotas3; }
		if($row7[33]!=''){ $mascotas4 = $row7[33]; $mascotas = $mascotas1.', '.$mascotas2.', '.$mascotas3.', '.$mascotas4; }
		if($row7[34]!=''){ $mascotas5 = $row7[34]; $mascotas = $mascotas1.', '.$mascotas2.', '.$mascotas3.', '.$mascotas4.', '.$mascotas5; }
	}
	//Enfermedades
	if($row7[35]=='' and $row7[36]=='' and $row7[37]=='' and $row7[38]=='' and $row7[39]==''){
		$enfermedades = 'INFORMACIÓN NO PROPORCIONADA'; 
	}else{
		if($row7[35]!=''){ $enfermedades1 = $row7[35]; $enfermedades = $enfermedades1; }
		if($row7[36]!=''){ $enfermedades2 = $row7[36]; $enfermedades = $enfermedades1.', '.$enfermedades2; }
		if($row7[37]!=''){ $enfermedades3 = $row7[37]; $enfermedades = $enfermedades1.', '.$enfermedades2.', '.$enfermedades3; }
		if($row7[38]!=''){ $enfermedades4 = $row7[38]; $enfermedades = $enfermedades1.', '.$enfermedades2.', '.$enfermedades3.', '.$enfermedades4; }
		if($row7[39]!=''){ $enfermedades5 = $row7[39]; $enfermedades = $enfermedades1.', '.$enfermedades2.', '.$enfermedades3.', '.$enfermedades4.', '.$enfermedades5; }
	}
	// APNP Adicciones
	if( $row7[0]=='' and $row7[1]=='' and $row7[2]=='' ){ $adicciones = 'INFORMACIÓN NO PROPORCIONADA'; }
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
		$adicciones = $dataAHF6;
	}
	// APNP Deportes
	if( $row7[9]=='' and $row7[10]=='' ){ $deportes = 'INFORMACIÓN NO PROPORCIONADA'; }
	else{
		if($row7[9]!=''){
			$deporte1 = $row7[9]; if($row7[11]!=''){$deporte1 = $deporte1.' CON UNA FRECUENCIA '.$row7[11];} $dataAHF7 = $deporte1;
		}
		if($row7[10]!=''){
			$deporte2 = $row7[10];
			if($row7[12]!=''){$deporte2 = $deporte2.' CON UNA FRECUENCIA '.$row7[12];} $dataAHF7 = $dataAHF7.', '.$deporte2;
		}
		if($row7[16]!=''){
			$deporte3 = $row7[16];
			if($row7[17]!=''){$deporte3 = $deporte3.' CON UNA FRECUENCIA '.$row7[17];} $dataAHF7 = $dataAHF7.', '.$deporte3;
		}
		$deportes = $dataAHF7;
	}
	// APNP Recreaciones
	if( $row7[13]=='' and $row7[14]=='' ){ $recreaciones = 'INFORMACIÓN NO PROPORCIONADA'; }
	else{
		if($row7[13]!=''){ $recreacion1 = $row7[13]; $dataAHF8 = $recreacion1; }
		if($row7[14]!=''){ $recreacion2 = $row7[14]; $dataAHF8 = $dataAHF8.', '.$recreacion2; }
		if($row7[18]!=''){ $recreacion3 = $row7[18]; $dataAHF8 = $dataAHF8.', '.$recreacion3; }
		$recreaciones = $dataAHF8;
	}
	// AHF NOTAS AHF
	if( $row7[15]=='' ){ $notas_apnp = 'SIN NOTAS'; }else { $notas_apnp = $row7[15]; }
	
	$aseo_personal = $row7[19]; $alimentacion = $row7[20]; $horas_dormir = $row7[21]; $tipo_vivienda = $row7[22];
	$habitantes = $row7[23]; $meterial_vivienda = $row7[24];
	
	mysql_select_db($database_horizonte, $horizonte);
	$result8 = mysql_query("SELECT hp.alergia1_hc, hp.alergia2_hc, hp.alergia3_hc, hp.alergia4_hc, hp.alergia5_hc, hp.alergia6_hc, hp.cirugia1, hp.cirugia2, hp.cirugia3, hp.transfusiones_hc, hp.app_notas from historia_clinica hp where hp.id_paciente_hc = $idP order by id_hc desc limit 1", $horizonte) or die (mysql_error());
 	$row8 = mysql_fetch_row($result8);
	// APP ALERGIAS
	if( $row8[0]=='' and $row8[1]=='' and $row8[2]=='' and $row8[3]=='' and $row8[4]=='' ){$alergias='INFORMACIÓN NO PROPORCIONADA';}
	else { 
		$dataAHF10 = $row8[0];
		if($row8[1]!=''){ $dataAHF10 = $dataAHF10.', '.$row8[1];} if($row8[2]!=''){ $dataAHF10 = $dataAHF10.', '.$row8[2];}
		if($row8[3]!=''){ $dataAHF10 = $dataAHF10.', '.$row8[3];} if($row8[4]!=''){ $dataAHF10 = $dataAHF10.', '.$row8[4];}
		if($row8[5]!=''){ $dataAHF10 = $dataAHF10.', '.$row8[5];}
		$alergias = $dataAHF10;
	}
	//APP Cirugías
	if( $row8[6]=='' and $row8[7]=='' and $row8[8]=='' ){ $cirugias = 'INFORMACIÓN NO PROPORCIONADA'; }else { 
		$dataAHF11 = $row8[6];
		if($row8[7]!=''){ $dataAHF11 = $dataAHF11.', '.$row8[7];} if($row8[8]!=''){ $cirugias = $dataAHF11.', '.$row8[8];}
	}
	//APP Transfusiones
	if( $row8[9]==''){ $transfusiones = 'INFORMACIÓN NO PROPORCIONADA'; }else { $transfusiones = $row8[9];}
	// APP NOTAS 
	if( $row8[10]=='' ){ $notas_app = 'SIN NOTAS'; }else { $notas_app = $row8[10]; }
	
	mysql_select_db($database_horizonte, $horizonte);
	$result9 = mysql_query("SELECT hp.menarca_hc, hp.ritmo_hc, hp.duracion_hc, hp.fur_hc, hp.ivsa_hc, hp.gestas_hc, hp.partos_hc, hp.cesareas_hc, hp.abortos_hc, hp.anticonceptivo_hc, a.anticonceptivo_at, hp.tiempo_uso_hc, hp.ago_notas_hc from historia_clinica hp left join catalogo_anticonceptivos a on a.id_at = hp.tipo_anticonceptivo_hc where hp.id_paciente_hc = $idP order by id_hc desc limit 1", $horizonte) or die (mysql_error());
 	$row9 = mysql_fetch_row($result9);
	// AGO 
	if( $row9[0]!='' ){ $menarca = $row9[0].' AÑOS'; }else{$menarca = '-';}
	if($row9[1]!=''){ if($row9[1]==1){$ritmo='REGULAR';}else{$ritmo='IRREGULAR';} }else{$ritmo='-';}
	if($row9[2]!=''){ $duracion = $row9[2].' DÍAS';}else{$duracion = '-';}
	if($row9[3]!=''){ $fur = $row9[3];}else{$fur = '-';}
	if($row9[4]!=''){ $ivsa = 'A LOS '.$row9[4].' AÑOS';}else{$ivsa ='-';}
	if($row9[5]!=''){ $gestas = $row9[5];}else{$gestas='-';}
	if($row9[6]!=''){ $partos = $row9[6];}else{$partos = '-';}
	if($row9[7]!=''){ $cesareas = $row9[7];}else{$cesareas ='-';}
	if($row9[8]!=''){ $abortos = $row9[8];}else{$abortos ='-';}
	if($row9[9]==1 ){ 
		$anticonceptivos = 'SI'; if($row9[10]!='' ){ if($row9[11]!=''){ $tiempoanticon = $row9[11].' AÑOS'; } $tipoanticon = $row9[10];
	}
	}else if($row9[9]==0){$anticonceptivos = 'NO'; $tipoanticon = '-'; $tiempoanticon = '-'; }
	else{$anticonceptivos = '-'; $tipoanticon = '-'; $tiempoanticon ='-';}
	if($row9[12]!=''){ $notas_ago =$row9[12];}else{$notas_ago = 'SIN NOTAS';}
	
	$hc="<br><div class='panel panel-primary small'><div class='panel-heading'><h3 class='panel-title'>ANTECEDENTES HEREDO FAMILIARES</h3></div><table class='table table-condensed table-bordered table-hover'><tr class='info'><td>FAMILIAR</td><td>ESTATUS</td><td>ENFERMEDADES</td></tr><tr><td>PADRE</td><td>".$estatus_padre1."</td><td>".$dataAHF."</td></tr><tr><td>MADRE</td><td>".$estatus_madre1."</td><td>".$dataAHF1."</td></tr><tr><td>CONYUGUE</td><td>".$estatus_conyugue1."</td><td>".$dataAHF3."</td></tr><tr class='info'><td>FAMILIAR</td><td>CANTIDAD</td><td>ENFERMEDADES</td></tr><tr><td>HERMANOS</td><td>".$cantidad_hermanos."</td><td>".$dataAHF2."</td></tr><tr><td>HIJOS</td><td>".$cantidad_hijos."</td><td>".$dataAHF4."</td></tr><tr class='info'><td colspan='3'>NOTAS</td></tr><tr><td colspan='3'>".$dataAHF5."</td></tr></table></div> <div class='panel panel-primary small'><div class='panel-heading'><h3 class='panel-title'>ANTECEDENTES PATOLÓGICOS NO PERSONALES</h3></div><table class='table table-condensed table-bordered table-hover'><tr class='info'><td colspan='3'>ADICCIONES</td></tr><tr><td colspan='3'>".$adicciones."</td></tr><tr class='info'><td colspan='3'>DEPORTES</td></tr><tr><td colspan='3'>".$deportes."</td></tr><tr class='info'><td colspan='3'>RECREACIONES</td></tr><tr><td colspan='3'>".$recreaciones."</td></tr><tr class='info'><td nowrap>ASEO PERSONAL</td><td nowrap>ALIMENTACIÓN</td><td nowrap>HORAS QUE DUERME</td></tr><tr><td>".$aseo_personal."</td><td>".$alimentacion."</td><td>".$horas_dormir."</td></tr><tr class='info'><td nowrap>TIPO DE VIVIENDA</td><td nowrap>HABITANTES</td><td nowrap>MATERIAL DE VIVIENDA</td></tr><tr><td>".$tipo_vivienda."</td><td>".$habitantes."</td><td>".$meterial_vivienda."</td></tr><tr class='info'><td nowrap>SERVICIOS EN VIVIENDA</td><td nowrap>MASCOTAS</td><td nowrap>VACUNAS</td></tr><tr><td>".$servicios."</td><td>".$mascotas."</td><td>".$vacunas."</td></tr><tr><td class='info' colspan='3'>NOTAS</td></tr><tr><td colspan='3'>".$notas_apnp."</td></tr></table></div> <div class='panel panel-primary small'><div class='panel-heading'><h3 class='panel-title'>ANTECEDENTES PATOLÓGICOS PERSONALES</h3></div><table class='table table-condensed table-bordered table-hover'><tr class='info'><td>ENFERMEDADES</td></tr><tr><td>".$enfermedades."</td></tr><tr class='info'><td>ALERGIAS</td></tr><tr><td>".$alergias."</td></tr><tr class='info'><td>CIRUGÍAS</td></tr><tr><td>".$cirugias."</td></tr><tr class='info'><td>NÚMERO DE TRANSFUSIONES</td></tr><tr><td>".$transfusiones."</td></tr><tr class='info'><td>NOTAS</td></tr><tr><td>".$notas_app."</td></tr></table></div> <div class='panel panel-primary small'><div class='panel-heading'><h3 class='panel-title'>ANTECEDENTES GINECO-OBSTÉTRICOS</h3></div><table class='table table-condensed table-bordered table-hover'><tr class='info'><td>MENARCA</td><td>RITMO</td><td>DURACIÓN</td></tr><tr><td>".$menarca."</td><td>".$ritmo."</td><td>".$duracion."</td></tr><tr class='info'><td>FECHA ÚLTIMA REGLA</td><td>I.V.S.A.</td><td>GESTAS</td></tr><tr><td>".$fur."</td><td>".$ivsa."</td><td>".$gestas."</td></tr><tr class='info'><td>PARTOS</td><td>CESAREAS</td><td>ABORTOS</td></tr><tr><td>".$partos."</td><td>".$cesareas."</td><td>".$abortos."</td></tr><tr class='info'><td>ANTICONCEPTIVOS</td><td>TIPO</td><td nowrap>TIEMPO DE USO</td></tr><tr><td>".$anticonceptivos."</td><td>".$tipoanticon."</td><td>".$tiempoanticon."</td></tr><tr class='info'><td colspan='3'>NOTAS</td></tr><tr><td colspan='3'>".$notas_ago."</td></tr><table></div>";
		
	mysql_select_db($database_horizonte, $horizonte);// para lab
	$result1d = mysql_query("SELECT v.id_vc, c.concepto_to from venta_conceptos v left join conceptos c on c.id_to = v.id_concepto_es where v.id_paciente_vc = $idP and v.temporal_vc = 0 and c.id_tipo_concepto_to = 3 and v.estatus_vc > 6 and c.concepto_to!='' order by v.id_vc desc limit 1 ", $horizonte) or die (mysql_error());
 	$row1d = mysql_fetch_row($result1d);
	
	mysql_select_db($database_horizonte, $horizonte); //Para el primer USG
	$result1w = mysql_query("SELECT id_vc from venta_conceptos left join conceptos on id_to = id_concepto_es where id_paciente_vc = $idP and temporal_vc = 0 and id_tipo_concepto_to = 4 and estatus_vc = 5 and concepto_to != '' and id_area_to = 58 order by id_vc desc limit 1 ", $horizonte) or die (mysql_error());
 	$row1w = mysql_fetch_row($result1w);
	
	mysql_select_db($database_horizonte, $horizonte); //Para la primer consulta
	$result1c = mysql_query("SELECT id_vc from venta_conceptos left join conceptos on id_to = id_concepto_es where id_vc < $idE and id_paciente_vc = $idP and id_tipo_concepto_to = 1 and estatus_vc = 6 and concepto_to != '' and temporal_vc = 0 order by fecha_venta_vc desc limit 1 ", $horizonte) or die (mysql_error());
 	$row1c = mysql_fetch_row($result1c);
	
	mysql_select_db($database_horizonte, $horizonte); //Para la primer servicios
	$result1s = mysql_query("SELECT id_vc from venta_conceptos left join conceptos on id_to = id_concepto_es where id_vc > $idE and id_paciente_vc = $idP and id_tipo_concepto_to = 2 and estatus_vc = 5 and concepto_to != '' order by id_vc desc limit 1 ", $horizonte) or die (mysql_error());
 	$row1s = mysql_fetch_row($result1s);
	
	mysql_select_db($database_horizonte, $horizonte); //Para el primer img
	$result1i = mysql_query("SELECT id_vc from venta_conceptos left join conceptos on id_to = id_concepto_es where id_paciente_vc = $idP and id_tipo_concepto_to = 4 and estatus_vc = 5 and concepto_to != '' and id_area_to not in (29,58,85) and temporal_vc = 0 order by id_vc desc limit 1 ", $horizonte) or die (mysql_error());
 	$row1i = mysql_fetch_row($result1i);
	
	mysql_select_db($database_horizonte, $horizonte); //Para el primer endo
	$result1e = mysql_query("SELECT id_vc from venta_conceptos left join conceptos on id_to = id_concepto_es where id_paciente_vc = $idP and id_tipo_concepto_to = 4 and estatus_vc = 5 and concepto_to != '' and id_area_to = 29 and temporal_vc = 0 order by id_vc asc limit 1 ", $horizonte) or die (mysql_error());
 	$row1e = mysql_fetch_row($result1e);
	
	mysql_select_db($database_horizonte, $horizonte); //Para el primer colpo
	$result1cl = mysql_query("SELECT id_vc from venta_conceptos left join conceptos on id_to = id_concepto_es where id_paciente_vc = $idP and id_tipo_concepto_to = 4 and estatus_vc = 5 and concepto_to != '' and id_area_to = 85 and temporal_vc = 0 order by id_vc desc limit 1 ", $horizonte) or die (mysql_error());
 	$row1cl = mysql_fetch_row($result1cl);
	
	echo $datos.'*;'.$fx.'*;'.$row[4].'*;'.$hc.'*;'.$row1d[0].'*;'.$row1d[1].'*;'.$row1w[0].'*;'.$row1c[0].'*;'.$row1s[0].'*;'.$row1i[0].'*;'.$row1e[0].'*;'.$row1cl[0];
 	//Cerrar conexión a la Base de Datos
 	mysql_close($horizonte);
?>