<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	$idP = sqlValue($_POST["idP"], "int"); $idU = sqlValue($_POST["idU"], "int"); $id_vc = sqlValue($_POST["id_vc"], "int");
		
	$now = date('d/m/Y H:i:s');

	$dia = date('d'); $mes = strtoupper(date('M')); $anio = date('Y'); $hora = date('H:i:s'); $mes1 = date('m');
	
	$fecha_hora = 'FECHA Y HORA DE ELABORACIÓN: '.$now;

	mysql_select_db($database_horizonte, $horizonte);
	$resultR = mysql_query("SELECT temporal_u, universidad_u, universidad_e_u from usuarios where id_u = $idU", $horizonte) or die (mysql_error());
	$rowR = mysql_fetch_row($resultR); $idSuc = sqlValue($rowR[0], "text"); $idUniversidadU = sqlValue($rowR[1], "int"); $idUniversidadUE = sqlValue($rowR[2], "int");

	mysql_select_db($database_horizonte, $horizonte); //Firma del médico que atiende
	$resultMNE = mysql_query("SELECT id_do, ext_do from documentos where aleatorio_do = $idSuc and que_es_do = 'DOCUMENTO' and tipo_quien_do = 3 and firma_do = 1 order by id_do desc limit 1", $horizonte) or die (mysql_error());
	$rowMNE = mysql_fetch_row($resultMNE); $nombreF1 = '../../usuarios/documentos/files/'.$rowMNE[0].'.'.$rowMNE[1];
	if($rowMNE){
		$encaNM = '<img src="usuarios/documentos/files/'.$rowMNE[0].'.'.$rowMNE[1].'" width="120" style="border:transparent;">';
	}else{$encaNM = "";}

	mysql_select_db($database_horizonte, $horizonte); //Logo uni del médico que atiende
	$resultMNE2 = mysql_query("SELECT id_do, ext_do from documentos where id_quien_do = $idUniversidadU and que_es_do = 'LOGOTIPO' and tipo_quien_do = 5 order by id_do desc limit 1", $horizonte) or die (mysql_error());
	$rowMNE2 = mysql_fetch_row($resultMNE2); $nombreF2 = '../../escuelas/logotipos/files/'.$rowMNE2[0].'.'.$rowMNE2[1];
	if($rowMNE2){
		$encaNM2 = '<img src="escuelas/logotipos/files/'.$rowMNE2[0].'.'.$rowMNE2[1].'" width="120" style="border:transparent;">';
	}else{$encaNM2 = "";}

	mysql_select_db($database_horizonte, $horizonte); //Logo uni espe del médico que atiende
	$resultMNE3 = mysql_query("SELECT id_do, ext_do from documentos where id_quien_do = $idUniversidadUE and que_es_do = 'LOGOTIPO' and tipo_quien_do = 5 order by id_do desc limit 1", $horizonte) or die (mysql_error());
	$rowMNE3 = mysql_fetch_row($resultMNE3); $nombreF3 = '../../escuelas/logotipos/files/'.$rowMNE3[0].'.'.$rowMNE3[1];
	if($rowMNE3){
		$encaNM3 = '<img src="escuelas/logotipos/files/'.$rowMNE3[0].'.'.$rowMNE3[1].'" width="120" style="border:transparent;">';
	}else{$encaNM3 = "";}

	mysql_select_db($database_horizonte, $horizonte);
	$resultVC = mysql_query("SELECT s.nombre_su, c.concepto_to, concat(t.abreviacion_ti, ' ', mr.nombre_u, ' ', mr.apaterno_u), mr.amaterno_u, v.id_concepto_es, o.observaciones_i_ov, o.referencia_ov, concat(t1.abreviacion_ti, ' ', ma.nombre_u, ' ', ma.apaterno_u), ma.amaterno_u, s.no_temp_su, s.clave_su, v.contador_vc, v.no_temp_vc from venta_conceptos v left join orden_venta o on o.referencia_ov = v.referencia_vc left join sucursales s on s.id_su = o.sucursal_ov left join conceptos c on c.id_to = v.id_concepto_es left join usuarios mr on mr.id_u = v.id_personal_medico_vc left join titulos t on t.id_ti = mr.id_titulo_u left join usuarios ma on ma.id_u = v.id_anesteciologo_vc left join titulos t1 on t.id_ti = ma.id_titulo_u where v.id_vc = $id_vc limit 1", $horizonte) or die (mysql_error());
 	$rowVC = mysql_fetch_row($resultVC); $idSucu = sqlValue($rowVC[9], "text"); $id_vcc = sqlValue($rowVC[4], "int"); $no_tempo_vc = sqlValue($rowVC[12], "text");

	$lista = ''; $k = 0; $lista1 = ''; $k1 = 0;
	mysql_select_db($database_horizonte, $horizonte);
	$consultaM = "SELECT m.metodo_me from asignar_metodo am left join conceptos b on b.aleatorio_c = am.aleatorio_ame left join metodos m on m.id_me = am.id_metodo_ame where b.id_to = $id_vcc group by am.id_metodo_ame ";
	$query = mysql_query($consultaM) or die (mysql_error());
	while ($fila = mysql_fetch_array($query)){ $lista = $lista.','.$fila['metodo_me']; $k++; };if($k>2){ $lista = 'DIVERSOS'; }$lista=substr($lista,1);

	mysql_select_db($database_horizonte, $horizonte);
	$consultaM1 ="SELECT m.muestra_mu from asignar_muestra am left join conceptos b on b.aleatorio_c = am.aleatorio_am left join muestras m on m.id_mu = am.id_muestra_am where b.id_to = $id_vcc group by am.id_muestra_am ";
	$query1 = mysql_query($consultaM1) or die (mysql_error());
	while ($fila1 = mysql_fetch_array($query1)){ $lista1 = $lista1.','.$fila1['muestra_mu']; $k1++; };if($k1>2){ $lista1 = 'DIVERSAS'; }$lista1=substr($lista1,1);

	mysql_select_db($database_horizonte, $horizonte);
	$resultVC_1 = mysql_query("SELECT max(v.contador_vc) from venta_conceptos v where v.no_temp_vc = $no_tempo_vc limit 1", $horizonte) or die (mysql_error());
 	$rowVC_1 = mysql_fetch_row($resultVC_1);

	mysql_select_db($database_horizonte, $horizonte); //Logo de la sucursal
	$resultMNE1 = mysql_query("SELECT id_do, ext_do from documentos where aleatorio_do = $idSucu and que_es_do = 'DOCUMENTO' and tipo_quien_do = 2 and perfil_do = 1 order by id_do desc limit 1", $horizonte) or die (mysql_error());
	$rowMNE1 = mysql_fetch_row($resultMNE1); $nombreF4 = '../../sucursales/documentos/files/'.$rowMNE1[0].'.'.$rowMNE1[1];
	if($rowMNE1){
		$encaNM1 = '<img src="sucursales/documentos/files/'.$rowMNE1[0].'.'.$rowMNE1[1].'" width="120">';
	}else{$encaNM1 = "";}
	
	$nombreF5 = '../../imagenes/generales/logo_medicina.png';
	if(file_exists($nombreF5)){
		$logoMedicina = '<img src="imagenes/generales/logo_medicina.png" width="100" style="border:transparent;">';
	}else{$logoMedicina = "";}
	
	mysql_select_db($database_horizonte, $horizonte);
	$resultAl = mysql_query("SELECT alergia1_hc, alergia2_hc, alergia3_hc, alergia4_hc, alergia5_hc, alergia6_hc from historia_clinica where id_paciente_hc = $idP order by id_hc desc limit 1", $horizonte) or die (mysql_error());
 	$rowAl = mysql_fetch_row($resultAl);
	
	if($rowAl[0]=='' and $rowAl[1]=='' and $rowAl[2]=='' and $rowAl[3]=='' and $rowAl[4]=='' and $rowAl[5]==''){$alergias='NINGUNA';}
	else{
		if($rowAl[0]!=''){$aler = $rowAl[0];} if($rowAl[1]!=''){$aler = $aler.', '.$rowAl[1];}
		if($rowAl[2]!=''){$aler = $aler.', '.$rowAl[2];} if($rowAl[3]!=''){$aler = $aler.', '.$rowAl[3];}
		if($rowAl[4]!=''){$aler = $aler.', '.$rowAl[4];} if($rowAl[5]!=''){$aler = $aler.', '.$rowAl[5];}
		if($aler[0]==', '){$alergias = substr($aler, 1);}else{$alergias = $aler;}
	}
	
	mysql_select_db($database_horizonte, $horizonte);
 	$result = mysql_query("SELECT concat(p.nombre_p, ' ', p.apaterno_p), p.amaterno_p, sx.cat_sexo, p.fNac_p, s.tipo_sangre from pacientes p left join catalogo_sexos sx on sx.id_sexo = p.sexo_p left join catalogo_tipo_sangre s on s.id_tipo_sangre = p.tSanguineo_p where p.id_p = $idP ", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result);
	
	$fecha1 = new DateTime($row[3]); $fecha2 = new DateTime(date("Y-m-d H:i:s")); $fecha = $fecha1->diff($fecha2);
	//printf('%d AÑOS %d MESES %d DÍAS %d HORAS %d MINUTOS', $fecha->y, $fecha->m, $fecha->d, $fecha->h, $fecha->i);
	$anos=$fecha->y; $meses=$fecha->m; $dias=$fecha->d; $horas=$fecha->h; $minutos=$fecha->i; $segundos=$fecha->s;
	if($anos>0){$row[3]=$anos." AÑOS";}
	if($anos<1){
		if($meses<=2 and $meses>=1){$row[3]=$meses." MES(ES) ".$dias." DÍA(S)";}
		if($meses>=3){$row[3]=$meses." MES(ES) ";}
		if($meses==0){$row[3]=$dias." DÍA(S)";}
		if($meses==0 and $dias<=1){$row[3]=$dias." DÍA(S) ".$horas." HORA(S)";}
		if($meses==0 and $dias<1){$row[3]=$horas." HORA(S) ".$minutos." MINUTO(S)";}
	} 
	if($anos>150 or $anos<0){$row[3]="DESCONOCIDA";}else{}
	
	mysql_select_db($database_horizonte, $horizonte);
	$resultM = mysql_query("SELECT concat(t.abreviacion_ti, ' ',u.nombre_u, ' ', u.apaterno_u), u.amaterno_u, concat('CÉDULA PROFESIONAL ',u.cedulaProfesional_u), u.cedulaProfesional_u, u.cedulaProfesionalE_u, e.nombre_especialidad, un.nombre_e, t.abreviacion_ti, u.temporal_u from usuarios u left join titulos t on t.id_ti = u.id_titulo_u left join especialidades e on e.id_es = u.especialidad_u left join catalogo_escuelas un on un.id_e = u.universidad_u where u.id_u = $idU ", $horizonte) or die (mysql_error());
 	$rowM = mysql_fetch_row($resultM); $temporal_u = sqlValue($rowM[8], "text");

	mysql_select_db($database_horizonte, $horizonte); 
	$resultFrts = mysql_query("SELECT count(id_fc) from formatos_conceptos where id_concepto_fc = $id_vcc and temporal_fc = $temporal_u", $horizonte) or die (mysql_error());
	$rowFrts = mysql_fetch_row($resultFrts);

	$resultFt = mysql_query("SELECT count(id_do) from documentos where aleatorio_do = $temporal_u and firma_do = 1 ", $horizonte) or die (mysql_error());
 	$rowFt = mysql_fetch_row($resultFt);
	
	if($rowFt[0]>0){
		//mysql_select_db($database_horizonte, $horizonte); 
		//$resultDo = mysql_query("SELECT ext_do, id_do from documentos where aleatorio_do = $tempU and firma_do = 1 limit 1", $horizonte) or die (mysql_error());
		//$rowDo = mysql_fetch_row($resultDo);
		//$myFirma = '<img src="usuarios/documentos/files/'.$rowDo[1].'.'.$rowDo[0].'" height="90" width="" style=" border-style:none;">'; contador_vc
		$myFirma = '';
	 }else{$myFirma = '';}
	
	mysql_select_db($database_horizonte, $horizonte);
	$result1s = mysql_query("SELECT s.t_sv, s.a_sv, s.fr_sv, s.fc_sv, s.temperatura_sv, s.oximetria_sv, t1.nombre_tg, t2.nombre_tg, t3.nombre_tg, s.a_ocular_sv, s.r_verbal, s.r_motriz, s.peso_sv, s.talla_sv, s.a_ocular_sv+s.r_verbal+s.r_motriz from signos_vitales s left join tabla_glasgow t1 on t1.valor_tg = s.a_ocular_sv and t1.tipo_tg = 1 left join tabla_glasgow t2 on t2.valor_tg = s.r_verbal and t2.tipo_tg = 2 left join tabla_glasgow t3 on t3.valor_tg = s.r_motriz and t3.tipo_tg = 3 where s.id_paciente_sv = $idP order by s.id_sv desc limit 1", $horizonte) or die (mysql_error());
 	$row1s = mysql_fetch_row($result1s);
	if($row1s[5] != NULL or $row1s[5] != ''){ $oxi_sv = 'OXIMETRÍA DE PULSO ('.$row1s[5].' % SaO2)';} else{$oxi_sv = '';}
	
	if($row1s[9]!=0 or $row1s[9]!=NULL){  $aocu = 'ABERTURA OCULAR: '.$row1s[6]; }else{$aocu = '';}
	if($row1s[10]!=0 or $row1s[10]!=NULL){  $rverb = ', RESPUESTA VERBAL: '.$row1s[7]; }else{$rverb = '';}
	if($row1s[11]!=0 or $row1s[11]!=NULL){  $rmotr = ', RESPUESTA MOTRIZ: '.$row1s[8]; }else{$rmotr = '';}
	if($row1s[10]>0){ $puntuacion_g = 'NEUROLÓGICAMENTE CON UNA PUNTUACIÓN DE GLASGLOW DE: '.$row1s[14]; } 
	$abitus = 'HÁBITUS EXTERIOR: '.$aocu.$rverb.$rmotr;
	
	$signos_v = 'SIGNOS VITALES: TENSIÓN ARTERIAL ('.$row1s[0].'/'.$row1s[1].' mmHg), FRECUENCIA CARDIACA ('.$row1s[3].' x min), FRECUENCIA RESPIRATORIA ('.$row1s[2].' x min), TEMPERATURA ('.$row1s[4].' ºC), '.$oxi_sv;
	
	$antropometria = 'PESO: '.$row1s[12].' Kg TALLA: '.$row1s[13].' m';
	
	mysql_select_db($database_horizonte, $horizonte); 
 	$resultH = mysql_query("SELECT a1.adiccion_ca, i1.inicio_ci, f1.frecuencia_cf, a2.adiccion_ca, i2.inicio_ci, f2.frecuencia_cf, a3.adiccion_ca, i3.inicio_ci, f3.frecuencia_cf from historia_clinica h left join catalogo_adicciones a1 on a1.id_ca = h.adiccion1 left join catalogo_inicios i1 on i1.id_ci = h.inicio_adiccion1 left join catalogo_frecuencias f1 on f1.if_cf = h.frecuencia_adiccion1 left join catalogo_adicciones a2 on a2.id_ca = h.adiccion2 left join catalogo_inicios i2 on i2.id_ci = h.inicio_adiccion2 left join catalogo_frecuencias f2 on f2.if_cf = h.frecuencia_adiccion2 left join catalogo_adicciones a3 on a3.id_ca = h.adiccion3 left join catalogo_inicios i3 on i3.id_ci = h.inicio_adiccion3 left join catalogo_frecuencias f3 on f3.if_cf = h.frecuencia_adiccion3 where h.id_paciente_hc = $idP", $horizonte) or die (mysql_error());
 	$rowH = mysql_fetch_row($resultH);
 
 	$conH = 0;
	if($rowH[0]!=NULL or $rowH[0]!=''){ $adiccion1 = 'ADICCION '.$rowH[2].' '.$rowH[0].' '.$rowH[1]; $conH++; }
 	if($rowH[3]!=NULL or $rowH[3]!=''){ $adiccion2 = ', ADICCION '.$rowH[5].' '.$rowH[3].' '.$rowH[4]; $conH++; }
 	if($rowH[6]!=NULL or $rowH[6]!=''){ $adiccion3 = ', ADICCION '.$rowH[8].' '.$rowH[6].' '.$rowH[7]; $conH++; }
 	if($conH==0){ $adicciones = 'ANTECEDENTES TABÁQUICOS, ALCOHÓLICOS Y SUSTANCIAS PSICOACTIVAS:'; }
 	else{$adicciones = $adiccion1.' '.$adiccion2.' '.$adiccion3;}
		
	$datos = $alergias.'-{]'.$row[3].'-{]'.$row[2].'-{]'.$row[0].' '.$row[1].'-{]'.$rowM[0].' '.$rowM[1].'-{]'.$signos_v.'-{]'.$abitus.'-{]'.$adicciones.'-{]'.$puntuacion_g.'-{]'.$antropometria.'-{]'.$fecha_hora.'-{]'.$rowM[0].' '.$rowM[1].'-{]'.$row[3].'-{]'.$rowM[3].'-{]'.$rowM[4].'-{]'.$row[3].'-{]'.$rowM[5].'-{]'.$dia.'-{]'.$mes1.'-{]'.$anio.'-{]'.$hora.'-{]'.$rowVC[0].'-{]'.$rowM[6].'-{]'.$row1s[12].'-{]'.$row1s[13].'-{]'.$row[2].'-{]'.$row[4].'-{]'.$rowM[7].'-{]'.$rowVC[1].'-{]'.$rowVC[2].' '.$rowVC[3].'-{]'.$mes.'-{]'.$myFirma.'-{]'.$rowFrts[0].'-{]'.$rowVC[4].'-{]'.$row1s[0].'-{]'.$row1s[1].'-{]'.$row1s[3].'-{]'.$row1s[2].'-{]'.$row1s[4].' ºC'.'-{]'.$rowVC[5].'-{]'.$rowVC[6].'-{]'.$rowVC[7].' '.$rowVC[8].'-{]'.$encaNM.'-{]'.$encaNM1.'-{]'.$encaNM2.'-{]'.$encaNM3.'-{]'.$logoMedicina.'-{]'.$rowVC[10].'-{]'.$rowVC[11].'-{]'.$rowVC_1[0].'-{]'.$lista.'-{]'.$lista1;
	
	echo $datos;
 	//Cerrar conexión a la Base de Datos
 	mysql_close($horizonte);
?>