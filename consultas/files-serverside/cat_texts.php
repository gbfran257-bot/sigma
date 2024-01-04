<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	$idP = sqlValue($_POST["idP"], "int"); $idU = sqlValue($_POST["idU"], "int"); $id_vc = sqlValue($_POST["id_vc"], "int");
		
	$now = date('d/m/Y H:i:s');

	$dia = date('d'); $mes = strtoupper(date('F')); $anio = date('Y'); $hora = date('H:i:s'); $mes1 = date('m');

	switch ($mes) {
		case 'JANUARY':
			$mes = "ENERO";
			break;
		case 'FEBRUARY':
			$mes = "FEBRERO";
			break;
		case 'MARCH':
			$mes = "MARZO";
			break;
		case 'APRIL':
			$mes = "ABRIL";
			break;
		case 'MAY':
			$mes = "MAYO";
			break;
		case 'JUNE':
			$mes = "JUNIO";
			break;
		case 'JULY':
			$mes = "JULIO";
			break;
		case 'AUGUST':
			$mes = "AGOSTO";
			break;
		case 'SEPTEMBER':
			$mes = "SEPTIEMBRE";
			break;
		case 'OCTOBER':
			$mes = "OCTUBRE";
			break;
		case 'NOVEMBER':
			$mes = "NOVIEMBRE";
			break;
		case 'DECEMBER':
			$mes = "DICIEMBRE";
			break;
		default:
			# code...
			break;
	}
	
	$fecha_hora = 'FECHA Y HORA DE ELABORACIÓN: '.$now;

	mysql_select_db($database_horizonte, $horizonte);
	$resultR = mysql_query("SELECT temporal_u, universidad_u, universidad_e_u from usuarios where id_u = $idU", $horizonte) or die (mysql_error());
	$rowR = mysql_fetch_row($resultR); $idSuc = sqlValue($rowR[0], "text"); $idUniversidadU = sqlValue($rowR[1], "int"); $idUniversidadUE = sqlValue($rowR[2], "int");

	//diagnosticos 
	$resultDiagnosticos = mysql_query("SELECT dx.nombre_di  from diagnosticos as dx left join dx_consultas dxc on  dxc.id_dx_dxc = dx.id_di  where id_c_dxc = $id_vc", $horizonte) or die (mysql_error());
	$dx_cont = '<table>';
	while ($diagnosticos = mysql_fetch_assoc($resultDiagnosticos)) {
		$dx_cont.=	"<tr> ".
						"<td style='font-size:10px;'>".$diagnosticos['nombre_di']."</td>". 
					"</tr>";
	}
	$dx_cont .= '</table>';

	// medicamentos
	$resultMedic = mysql_query("SELECT c.concepto_to, m.nombre_generico_med, m.cantidad_med, m.descripcion_med, c.descripcion_to  from medicamentos_receta as md left join conceptos c on  c.id_to = md.id_med_mr left join medicamentos m on c.id_medicamento_g = m.id_med where md.id_co_mr = $id_vc", $horizonte) or die (mysql_error());
	$md_cont = '<table>';
	$med_cont = 0;
	while ($medicamentos = mysql_fetch_assoc($resultMedic)) {
		$med_cont++;
		$md_cont.=	"<tr> ".
						"<td align='left' style='font-size:18px;'>".$med_cont."</td>". 
						"<td align='left' style='font-size:18px; text-decoration:underline;'> 
							<span >
								".strtolower($medicamentos['concepto_to']).
							"</span>
							(".strtolower($medicamentos['nombre_generico_med']).") ".strtolower($medicamentos['cantidad_med'])." ".strtolower($medicamentos['descripcion_med'])."
						</td>". 
					"</tr>
					<tr>".
						"<td align='left' style='font-size:18px;'></td>". 
						"<td align='left' style='font-size:15px;'>".strtolower($medicamentos['descripcion_to'])."</td>". 
					"</tr>";
	}
	$md_cont .= '</table>';

	$server_url = $_SERVER['SERVER_NAME'] == "localhost" ? "http://localhost/sigma" : "https://pruebascruzroja.preunisains.com";

	mysql_select_db($database_horizonte, $horizonte); //Firma del médico que atiende
	$resultMNE = mysql_query("SELECT id_do, ext_do from documentos where aleatorio_do = $idSuc and que_es_do = 'DOCUMENTO' and tipo_quien_do = 3 and firma_do = 1 order by id_do desc limit 1", $horizonte) or die (mysql_error());
	$rowMNE = mysql_fetch_row($resultMNE); $nombreF1 = '../../usuarios/documentos/files/'.$rowMNE[0].'.'.$rowMNE[1];
	if($rowMNE){
		$encaNM = '<img src="'.$server_url.'/usuarios/documentos/files/'.$rowMNE[0].'.'.$rowMNE[1].'" width="120" style="border:transparent;">';
	}else{$encaNM = "";}

	mysql_select_db($database_horizonte, $horizonte); //Logo uni del médico que atiende
	$resultMNE2 = mysql_query("SELECT id_do, ext_do from documentos where id_quien_do = $idUniversidadU and que_es_do = 'LOGOTIPO' and tipo_quien_do = 5 order by id_do desc limit 1", $horizonte) or die (mysql_error());
	$rowMNE2 = mysql_fetch_row($resultMNE2); $nombreF2 = '../../escuelas/logotipos/files/'.$rowMNE2[0].'.'.$rowMNE2[1];
	if($rowMNE2){
		$encaNM2 = '<img src="'.$server_url.'/escuelas/logotipos/files/'.$rowMNE2[0].'.'.$rowMNE2[1].'" width="120" style="border:transparent;">';
	}else{$encaNM2 = "";}

	mysql_select_db($database_horizonte, $horizonte); //Logo uni espe del médico que atiende
	$resultMNE3 = mysql_query("SELECT id_do, ext_do from documentos where id_quien_do = $idUniversidadUE and que_es_do = 'LOGOTIPO' and tipo_quien_do = 5 order by id_do desc limit 1", $horizonte) or die (mysql_error());
	$rowMNE3 = mysql_fetch_row($resultMNE3); $nombreF3 = '../../escuelas/logotipos/files/'.$rowMNE3[0].'.'.$rowMNE3[1];
	if($rowMNE3){
		$encaNM3 = '<img src="'.$server_url.'/escuelas/logotipos/files/'.$rowMNE3[0].'.'.$rowMNE3[1].'" width="120" style="border:transparent;">';
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
		$encaNM1 = '<img src="'.$server_url.'/sucursales/documentos/files/'.$rowMNE1[0].'.'.$rowMNE1[1].'" width="120">';
	}else{$encaNM1 = "";}

	//LOGOS SUCURSALES NUMERADOS 
	mysql_select_db($database_horizonte, $horizonte);
	$su="SELECT s.no_temp_su from sucursales s left join usuarios u on u.idSucursal_u = s.id_su where u.id_u = $idU limit 1";
	$sucur = mysql_query($su, $horizonte) or die (mysql_error());
 	$sucur1 = mysql_fetch_row($sucur);
	$idSucuf = $sucur1[0];
	// echo $su;
	// echo $idSucuf;

	$px1 = "80";
	$px2 = "80";
	$px3 = "80";
	$px4 = "80";
	$px5 = "200";
	$px6 = "200";
	$px7 = "200";
	$px8 = "200";
	$px9 = "200";
	$px10 = "200";
	$px11 = "200";
	$px12 = "200";
	$px13 = "200";
	$px14 = "400";
	$px15 = "400";

	$logosA = array($px1,$px2,$px3,$px4,$px5,$px6,$px7,$px8,$px9,$px10,$px11,$px12,$px13,$px14,$px15);
	$logosA1 =array();
	$l =0;
	for ($i=1; $i < 16; $i++) { 
		mysql_select_db($database_horizonte, $horizonte); //Logo de la sucursal
		$resul_LogoS1 = mysql_query("SELECT id_do, ext_do from documentos where aleatorio_do = '$idSucuf' and que_es_do = 'DOCUMENTO' and tipo_quien_do = 2 and num_suc_do = $i ", $horizonte) or die (mysql_error());
		$rowLogo = mysql_fetch_row($resul_LogoS1); 
		if($rowLogo){
			$conPx = $l + 1;
			$logo= '<img src="'.$server_url.'/sucursales/documentos/files/'.$rowLogo[0].'.'.$rowLogo[1].'" width="'.$logosA[$l].'">';
		}else{
			$logo = "";
		}
		$logosA1[$l]= $logo;	
		$l++;
	} //fin LOGOS SUCURSALES NUMERADOS 


	$nombreF5 = '../../imagenes/generales/logo_medicina.png';
	if(file_exists($nombreF5)){
		$logoMedicina = '<img src="'.$server_url.'/imagenes/generales/logo_medicina.png" width="100" style="border:transparent;">';
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
	$feNac = date("d-m-Y",strtotime($row[3]));
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
	$result1s = mysql_query("SELECT s.t_sv, s.a_sv, s.fr_sv, s.fc_sv, s.temperatura_sv, s.oximetria_sv, t1.nombre_tg, t2.nombre_tg, t3.nombre_tg, s.a_ocular_sv, ".
	"s.r_verbal, s.r_motriz, s.peso_sv, s.talla_sv, s.a_ocular_sv+s.r_verbal+s.r_motriz, s.destroxtis from signos_vitales s left join tabla_glasgow t1 on t1.valor_tg = s.a_ocular_sv ".
	"and t1.tipo_tg = 1 left join tabla_glasgow t2 on t2.valor_tg = s.r_verbal and t2.tipo_tg = 2 left join tabla_glasgow t3 on t3.valor_tg = s.r_motriz and t3.tipo_tg = 3 ".
	"where s.id_paciente_sv = $idP order by s.id_sv desc limit 1", $horizonte) or die (mysql_error());
 	$row1s = mysql_fetch_row($result1s);
	if($row1s[5] != NULL or $row1s[5] != ''){ $oxi_sv = 'OXIMETRÍA DE PULSO ('.$row1s[5].' % SaO2)';} else{$oxi_sv = '';}
	
	if($row1s[9]!=0 or $row1s[9]!=NULL){  $aocu = 'ABERTURA OCULAR: '.$row1s[6]; }else{$aocu = '';}
	if($row1s[10]!=0 or $row1s[10]!=NULL){  $rverb = ', RESPUESTA VERBAL: '.$row1s[7]; }else{$rverb = '';}
	if($row1s[11]!=0 or $row1s[11]!=NULL){  $rmotr = ', RESPUESTA MOTRIZ: '.$row1s[8]; }else{$rmotr = '';}
	if($row1s[10]>0){ $puntuacion_g = 'NEUROLÓGICAMENTE CON UNA PUNTUACIÓN DE GLASGLOW DE: '.$row1s[14]; } 
	$abitus = 'HÁBITUS EXTERIOR: '.$aocu.$rverb.$rmotr;
	
	$signos_v = 'SIGNOS VITALES: TENSIÓN ARTERIAL ('.$row1s[0].'/'.$row1s[1].' mmHg), FRECUENCIA CARDIACA ('.$row1s[3].' x min), FRECUENCIA RESPIRATORIA ('.$row1s[2].
	' x min), TEMPERATURA ('.$row1s[4].' ºC), '.$oxi_sv;
	
	$antropometria = 'PESO: '.$row1s[12].' Kg TALLA: '.$row1s[13].' m';
	
	mysql_select_db($database_horizonte, $horizonte); 
 	$resultH = mysql_query("SELECT a1.adiccion_ca, i1.inicio_ci, f1.frecuencia_cf, a2.adiccion_ca, i2.inicio_ci, f2.frecuencia_cf, a3.adiccion_ca, ".
	"i3.inicio_ci, f3.frecuencia_cf, h.estatus_padre_hc, h.estatus_madre_hc, h.estatus_conyugue, ahf_padre_1, ahf_padre_2, ahf_padre_3, ahf_padre_4, ".
	"ahf_madre_1, ahf_madre_2, ahf_madre_3, ahf_madre_4, ahf_conyugue_1, ahf_conyugue_2, ahf_conyugue_3, ahf_conyugue_4, no_hermanos, ahf_hnos_1, ".
	"ahf_hnos_2, ahf_hnos_3, ahf_hnos_4, no_hijos_hc, ahf_hijos_1, ahf_hijos_2, ahf_hijos_3, ahf_hijos_4, ahf_notas, ".
	"a1.adiccion_ca, a2.adiccion_ca, a3.adiccion_ca, i1.inicio_ci, i2.inicio_ci, i3.inicio_ci, f1.frecuencia_cf, f2.frecuencia_cf, f3.frecuencia_cf, ".
	
	"d1.deporte_dp, d2.deporte_dp, fd1.frecuencia_cf, fd2.frecuencia_cf, r1.recreacion_cr, r2.recreacion_cr, h.apnp_notas, d3.deporte_dp, fd3.frecuencia_cf, r3.recreacion_cr, ap.aseo_ap, ta.alimentacion_ta, h.horas_dormir_hc, cv.concepto_vivienda, h.habitantes_hc, mv.material_mv, cs1.servicio_cs, cs2.servicio_cs, cs3.servicio_cs, cs4.servicio_cs, cs5.servicio_cs, cm1.mascota_cm, cm2.mascota_cm, cm3.mascota_cm, cm4.mascota_cm, cm5.mascota_cm, cv1.vacuna_v, cv2.vacuna_v, cv3.vacuna_v, cv4.vacuna_v, cv5.vacuna_v, e1.nombre_ef, e2.nombre_ef, e3.nombre_ef, e4.nombre_ef, e5.nombre_ef, h.cirugia1, h.cirugia2, h.cirugia3, h.transfusiones_hc, h.app_notas, h.menarca_hc, h.ritmo_hc, h.duracion_hc, h.fur_hc, h.ivsa_hc, h.gestas_hc, h.partos_hc, h.cesareas_hc, h.abortos_hc, h.anticonceptivo_hc, a.anticonceptivo_at, h.tiempo_uso_hc, h.ago_notas_hc ".
	"from historia_clinica h ".
	"left join catalogo_adicciones a1 on a1.id_ca = h.adiccion1 ".
	"left join catalogo_inicios i1 on i1.id_ci = h.inicio_adiccion1 ".
	"left join catalogo_frecuencias f1 on f1.if_cf = h.frecuencia_adiccion1 ".
	"left join catalogo_adicciones a2 on a2.id_ca = h.adiccion2 ".
	"left join catalogo_inicios i2 on i2.id_ci = h.inicio_adiccion2 ".
	"left join catalogo_frecuencias f2 on f2.if_cf = h.frecuencia_adiccion2 ".
	"left join catalogo_adicciones a3 on a3.id_ca = h.adiccion3 ".
	"left join catalogo_inicios i3 on i3.id_ci = h.inicio_adiccion3 ".
	"left join catalogo_frecuencias f3 on f3.if_cf = h.frecuencia_adiccion3 ".
	"left join deportes d1 on d1.id_dp = h.deporte1 ".
	"left join deportes d2 on d2.id_dp = h.deporte2 ".
	"left join catalogo_frecuencias fd1 on fd1.if_cf = h.frecuencia_deporte1 ".
	"left join catalogo_frecuencias fd2 on fd2.if_cf = h.frecuencia_deporte2 ".
	"left join catalogo_recreaciones r1 on r1.id_cr = h.recreacion1 ".
	"left join catalogo_recreaciones r2 on r2.id_cr = h.recreacion2 ".
	"left join deportes d3 on d3.id_dp = h.deporte3 ".
	"left join catalogo_frecuencias fd3 on fd3.if_cf = h.frecuencia_deporte3 ".
	"left join catalogo_recreaciones r3 on r3.id_cr = h.recreacion3 ".
	"left join catalogo_aseo_personal ap on ap.id_ap = h.aseo_personal_hc ".
	"left join catalogo_tipo_alimentacion ta on ta.id_ta = h.alimentacion_hc ".
	"left join catalogo_vivienda cv on cv.id_vivienda = h.vivienda_hc ".
	"left join catalogo_maerial_vivienda mv on mv.id_mv = h.mat_vivienda1 ".
	"left join catalogo_servicios cs1 on cs1.id_cs = h.servicios1 ".
	"left join catalogo_servicios cs2 on cs2.id_cs = h.servicios2 ".
	"left join catalogo_servicios cs3 on cs3.id_cs = h.servicios3 ".
	"left join catalogo_servicios cs4 on cs4.id_cs = h.servicios4 ".
	"left join catalogo_servicios cs5 on cs5.id_cs = h.servicios5 ".
	"left join catalogo_mascotas cm1 on cm1.id_cm = h.mascotas1_hc ".
	"left join catalogo_mascotas cm2 on cm2.id_cm = h.mascotas2_hc ".
	"left join catalogo_mascotas cm3 on cm3.id_cm = h.mascotas3_hc ".
	"left join catalogo_mascotas cm4 on cm4.id_cm = h.mascotas4_hc ".
	"left join catalogo_mascotas cm5 on cm5.id_cm = h.mascotas5_hc ".
	"left join catalogo_vacunas cv1 on cv1.id_v = h.vacunas1 ".
	"left join catalogo_vacunas cv2 on cv2.id_v = h.vacunas2 ".
	"left join catalogo_vacunas cv3 on cv3.id_v = h.vacunas3 ".
	"left join catalogo_vacunas cv4 on cv4.id_v = h.vacunas4 ".
	"left join catalogo_vacunas cv5 on cv5.id_v = h.vacunas5 ".
	"left join enfermedades e1 on e1.id_ef = h.enfermedad1 ".
	"left join enfermedades e2 on e2.id_ef = h.enfermedad2 ".
	"left join enfermedades e3 on e3.id_ef = h.enfermedad3 ".
	"left join enfermedades e4 on e4.id_ef = h.enfermedad4 ".
	"left join enfermedades e5 on e5.id_ef = h.enfermedad5 ".
	"left join catalogo_anticonceptivos a on a.id_at = h.tipo_anticonceptivo_hc ".
	"where h.id_paciente_hc = $idP order by h.id_hc desc", $horizonte) or die (mysql_error());
 	$rowH = mysql_fetch_row($resultH);
	
 	$conH = 0;
	if($rowH[0]!=NULL or $rowH[0]!=''){ $adiccion1 = 'ADICCION '.$rowH[2].' '.$rowH[0].' '.$rowH[1]; $conH++; }
 	if($rowH[3]!=NULL or $rowH[3]!=''){ $adiccion2 = ', ADICCION '.$rowH[5].' '.$rowH[3].' '.$rowH[4]; $conH++; }
 	if($rowH[6]!=NULL or $rowH[6]!=''){ $adiccion3 = ', ADICCION '.$rowH[8].' '.$rowH[6].' '.$rowH[7]; $conH++; }
 	if($conH==0){ $adicciones = 'ANTECEDENTES TABÁQUICOS, ALCOHÓLICOS Y SUSTANCIAS PSICOACTIVAS:'; }
 	else{$adicciones = $adiccion1.' '.$adiccion2.' '.$adiccion3;}
	$estatus[1] = "VIVO";
	$estatus[2] = "FINADO";
	$enfermedades[6] = 'ALERGIAS';
	$enfermedades[15] = 'ASMA';
	$enfermedades[1] = 'CANCER';
	$enfermedades[2] = 'CARDIOPATIAS';
	$enfermedades[5] = 'DIABETES';
	$enfermedades[14] = 'EN AMIGDALAS';
	$enfermedades[16] = 'EN BRONQUIOS';
	$enfermedades[13] = 'EN OIDOS';
	$enfermedades[18] = 'ENDOCRINAS';
	$enfermedades[8] = 'EPILEPSIA';
	$enfermedades[4] = 'HIPERTENSION';
	$enfermedades[9] = 'MALFORMACIONES';
	$enfermedades[19] = 'OSTEOMUSCULARES';
	$enfermedades[12] = 'SARAMPION';
	$enfermedades[17] = 'SEXUALES';
	$enfermedades[7] = 'SIDA';
	$enfermedades[10] = 'T.MENTALES';
	$enfermedades[3] = 'TUBERCULOSIS';
	$enfermedades[11] = 'VARICELA';

	$enfermedadesPadre = (empty($rowH[12]) ? '' : $enfermedades[$rowH[12]]);
	$enfermedadesPadre .= (empty($rowH[13]) ? '' : (empty($enfermedadesPadre) ? '' : ', '). $enfermedades[$rowH[13]]);
	$enfermedadesPadre .= (empty($rowH[14]) ? '' : (empty($enfermedadesPadre) ? '' : ', '). $enfermedades[$rowH[14]]);
	$enfermedadesPadre .= (empty($rowH[15]) ? '' : (empty($enfermedadesPadre) ? '' : ', '). $enfermedades[$rowH[15]]);

	$enfermedadesMadre = (empty($rowH[16]) ? '' : $enfermedades[$rowH[16]]);
	$enfermedadesMadre .= (empty($rowH[17]) ? '' : (empty($enfermedadesMadre) ? '' : ', '). $enfermedades[$rowH[17]]);
	$enfermedadesMadre .= (empty($rowH[18]) ? '' : (empty($enfermedadesMadre) ? '' : ', '). $enfermedades[$rowH[18]]);
	$enfermedadesMadre .= (empty($rowH[19]) ? '' : (empty($enfermedadesMadre) ? '' : ', '). $enfermedades[$rowH[19]]);

	$enfermedadesConyugue = (empty($rowH[20]) ? '' : $enfermedades[$rowH[20]]);
	$enfermedadesConyugue .= (empty($rowH[21]) ? '' : (empty($enfermedadesConyugue) ? '' : ', '). $enfermedades[$rowH[21]]);
	$enfermedadesConyugue .= (empty($rowH[22]) ? '' : (empty($enfermedadesConyugue) ? '' : ', '). $enfermedades[$rowH[22]]);
	$enfermedadesConyugue .= (empty($rowH[23]) ? '' : (empty($enfermedadesConyugue) ? '' : ', '). $enfermedades[$rowH[23]]);

	$enfermedadesHermanos = (empty($rowH[25]) ? '' : $enfermedades[$rowH[25]]);
	$enfermedadesHermanos .= (empty($rowH[26]) ? '' : (empty($enfermedadesHermanos) ? '' : ', '). $enfermedades[$rowH[26]]);
	$enfermedadesHermanos .= (empty($rowH[27]) ? '' : (empty($enfermedadesHermanos) ? '' : ', '). $enfermedades[$rowH[27]]);
	$enfermedadesHermanos .= (empty($rowH[28]) ? '' : (empty($enfermedadesHermanos) ? '' : ', '). $enfermedades[$rowH[28]]);

	$enfermedadesHijos = (empty($rowH[30]) ? '' : $enfermedades[$rowH[30]]);
	$enfermedadesHijos .= (empty($rowH[31]) ? '' : (empty($enfermedadesHijos) ? '' : ', '). $enfermedades[$rowH[31]]);
	$enfermedadesHijos .= (empty($rowH[32]) ? '' : (empty($enfermedadesHijos) ? '' : ', '). $enfermedades[$rowH[32]]);
	$enfermedadesHijos .= (empty($rowH[33]) ? '' : (empty($enfermedadesHijos) ? '' : ', '). $enfermedades[$rowH[33]]);

	$ahf = "<table width='100%'>".
	 	"<tr><th colspan='3'>ANTECEDENTES HEREDO FAMILIARES</th></tr>".
		"<tr><th style='text-align: left'>Familiar</th><th style='text-align: left'>Estatus</th><th style='text-align: left'>Enfermedades</th></tr>".
		"<tr><td>Padre</td><td>".(empty($rowH[9]) ? '-' : $estatus[$rowH[9]])."</td><td>".$enfermedadesPadre."</td></tr>".
		"<tr><td>Madre</td><td>".(empty($rowH[10]) ? '-' : $estatus[$rowH[10]])."</td><td>".$enfermedadesMadre."</td></tr>".
		"<tr><td>Conyugue</td><td>".(empty($rowH[11]) ? '-' : $estatus[$rowH[11]])."</td><td>".$enfermedadesConyugue."</td></tr>".
		"<tr><th style='text-align: left'>Familiar</th><th style='text-align: left'>Cantidad</th><th style='text-align: left'>Enfermedades</th></tr>".
		"<tr><td>Hermanos</td><td>".$rowH[24]."</td><td>".$enfermedadesHermanos."</td></tr>".
		"<tr><td>Hijos</td><td>".$rowH[29]."</td><td>".$enfermedadesHijos."</td></tr>".
		"<tr><th colspan='3' style='text-align: left'>Notas</th></tr>".
		"<tr><td colspan='3'>".$rowH[34]."</td></tr>".
		"</table>";

	// APNP Adicciones
	if( $rowH[35]=='' and $rowH[36]=='' and $rowH[37]=='' ){ $adicciones = 'INFORMACIÓN NO PROPORCIONADA'; }
	else{
		if($rowH[35]!=''){
			$adiccion1 = $rowH[35];
			if($rowH[38]!=''){$adiccion1 = $adiccion1.' '.$rowH[38];}
			if($rowH[41]!=''){$adiccion1 = $adiccion1.' CON UNA FRECUENCIA '.$rowH[41];}
			$dataAHF6 = $adiccion1;
		}
		if($rowH[36]!=''){
			$adiccion2 = $rowH[36];
			if($rowH[39]!=''){$adiccion2 = $adiccion2.' '.$rowH[39];}
			if($rowH[42]!=''){$adiccion2 = $adiccion2.' CON UNA FRECUENCIA '.$rowH[42];}
			$dataAHF6 = $dataAHF6.', '.$adiccion2;
		}
		if($rowH[37]!=''){
			$adiccion3 = $rowH[37];
			if($rowH[40]!=''){$adiccion3 = $adiccion3.' '.$rowH[40];}
			if($rowH[43]!=''){$adiccion3 = $adiccion3.' CON UNA FRECUENCIA '.$rowH[43];}
			$dataAHF6 = $dataAHF6.', '.$adiccion3;
		}
		$adicciones = $dataAHF6;
	}
	// APNP Deportes
	if( $rowH[44]=='' and $rowH[45]=='' ){ $deportes = 'INFORMACIÓN NO PROPORCIONADA'; }
	else{
		if($rowH[44]!=''){
			$deporte1 = $rowH[44]; if($rowH[46]!=''){$deporte1 = $deporte1.' CON UNA FRECUENCIA '.$rowH[46];} $dataAHF7 = $deporte1;
		}
		if($rowH[45]!=''){
			$deporte2 = $rowH[45];
			if($rowH[47]!=''){$deporte2 = $deporte2.' CON UNA FRECUENCIA '.$rowH[47];} $dataAHF7 = $dataAHF7.', '.$deporte2;
		}
		if($rowH[51]!=''){
			$deporte3 = $rowH[51];
			if($rowH[52]!=''){$deporte3 = $deporte3.' CON UNA FRECUENCIA '.$rowH[52];} $dataAHF7 = $dataAHF7.', '.$deporte3;
		}
		$deportes = $dataAHF7;
	}
	// APNP Recreaciones
	if( $rowH[48]=='' and $rowH[49]=='' ){ $recreaciones = 'INFORMACIÓN NO PROPORCIONADA'; }
	else{
		if($rowH[48]!=''){ $recreacion1 = $rowH[48]; $dataAHF8 = $recreacion1; }
		if($rowH[49]!=''){ $recreacion2 = $rowH[49]; $dataAHF8 = $dataAHF8.', '.$recreacion2; }
		if($rowH[53]!=''){ $recreacion3 = $rowH[53]; $dataAHF8 = $dataAHF8.', '.$recreacion3; }
		$recreaciones = $dataAHF8;
	}
	// AHF NOTAS AHF
	if( $rowH[50]=='' ){ $notas_apnp = 'SIN NOTAS'; }else { $notas_apnp = $rowH[50]; }
	
	$aseo_personal = $rowH[54]; $alimentacion = $rowH[55]; $horas_dormir = $rowH[56]; $tipo_vivienda = $rowH[57];
	$habitantes = $rowH[58]; $meterial_vivienda = $rowH[59];
	//Servicios en casa
	if($rowH[60]=='' and $rowH[61]=='' and $rowH[62]=='' and $rowH[63]=='' and $rowH[64]==''){
		$servicios = 'INFORMACIÓN NO PROPORCIONADA'; 
	}else{
		if($rowH[60]!=''){ $servicios1 = $rowH[60]; $servicios = $servicios1; }
		if($rowH[61]!=''){ $servicios2 = $rowH[61]; $servicios = $servicios1.', '.$servicios2; }
		if($rowH[62]!=''){ $servicios3 = $rowH[62]; $servicios = $servicios1.', '.$servicios2.', '.$servicios3; }
		if($rowH[63]!=''){ $servicios4 = $rowH[63]; $servicios = $servicios1.', '.$servicios2.', '.$servicios3.', '.$servicios4; }
		if($rowH[64]!=''){ $servicios5 = $rowH[64]; $servicios = $servicios1.', '.$servicios2.', '.$servicios3.', '.$servicios4.', '.$servicios5; }
	}
	//Mascotas en casa
	if($rowH[65]=='' and $rowH[66]=='' and $rowH[67]=='' and $rowH[68]=='' and $rowH[69]==''){
		$mascotas = 'INFORMACIÓN NO PROPORCIONADA'; 
	}else{
		if($rowH[65]!=''){ $mascotas1 = $rowH[65]; $mascotas = $mascotas1; }
		if($rowH[66]!=''){ $mascotas2 = $rowH[66]; $mascotas = $mascotas1.', '.$mascotas2; }
		if($rowH[67]!=''){ $mascotas3 = $rowH[67]; $mascotas = $mascotas1.', '.$mascotas2.', '.$mascotas3; }
		if($rowH[68]!=''){ $mascotas4 = $rowH[68]; $mascotas = $mascotas1.', '.$mascotas2.', '.$mascotas3.', '.$mascotas4; }
		if($rowH[69]!=''){ $mascotas5 = $rowH[69]; $mascotas = $mascotas1.', '.$mascotas2.', '.$mascotas3.', '.$mascotas4.', '.$mascotas5; }
	}
	//Vacunas
	if($rowH[70]=='' and $rowH[71]=='' and $rowH[72]=='' and $rowH[73]=='' and $rowH[74]==''){
		$vacunas = 'INFORMACIÓN NO PROPORCIONADA'; 
	}else{
		if($rowH[70]!=''){ $vacunas1 = $rowH[70]; $vacunas = $vacunas1; }
		if($rowH[71]!=''){ $vacunas2 = $rowH[71]; $vacunas = $vacunas1.', '.$vacunas2; }
		if($rowH[72]!=''){ $vacunas3 = $rowH[72]; $vacunas = $vacunas1.', '.$vacunas2.', '.$vacunas3; }
		if($rowH[73]!=''){ $vacunas4 = $rowH[73]; $vacunas = $vacunas1.', '.$vacunas2.', '.$vacunas3.', '.$vacunas4; }
		if($rowH[74]!=''){ $vacunas5 = $rowH[74]; $vacunas = $vacunas1.', '.$vacunas2.', '.$vacunas3.', '.$vacunas4.', '.$vacunas5; }
	}
	$apnp = "<table width='100%'>".
		"<tr><th colspan='3'>ANTECEDENTES PATOLÓGICOS NO PERSONALES</th></tr>".
	 	"<tr><th colspan='3' style='text-align: left'>Adicciones</th></tr>".
		"<tr><td colspan='3'>".$adicciones."</td></tr>".
		"<tr><th colspan='3' style='text-align: left'>Deportes</th></tr>".
	    "<tr><td colspan='3'>".$deportes."</td></tr>".
	    "<tr><th colspan='3' style='text-align: left'>Recreaciones</th></tr>".
	    "<tr><td colspan='3'>".$recreaciones."</td></tr>".
		"<tr><th style='text-align: left'>Aseo personal</th><th style='text-align: left'>Alimentación</th><th style='text-align: left'>Horas que duerme</th></tr>".
		"<tr><td>".$aseo_personal."</td><td>".$alimentacion."</td><td>".$horas_dormir."</td></tr>".
		"<tr><th style='text-align: left'>Tipo de vivienda</th><th style='text-align: left'>Habitantes</th><th style='text-align: left'>Material de vivienda</th></tr>".
		"<tr><td>".$tipo_vivienda."</td><td>".$habitantes."</td><td>".$meterial_vivienda."</td></tr>".
		"<tr><th style='text-align: left'>Servicios de vivienda</th><th style='text-align: left'>Mascotas</th><th style='text-align: left'>Vacunas</th></tr>".
		"<tr><td>".$servicios."</td><td>".$mascotas."</td><td>".$vacunas."</td></tr>".
		"<tr><th colspan='3' style='text-align: left'>Notas</th></tr>".
		"<tr><td colspan='3'>".$notas_apnp."</td></tr>".
		"</table>";

	//Enfermedades
	if($rowH[75]=='' and $rowH[76]=='' and $rowH[77]=='' and $rowH[78]=='' and $rowH[79]==''){
		$enfermedades = 'INFORMACIÓN NO PROPORCIONADA'; 
	}else{
		if($rowH[75]!=''){ $enfermedades1 = $rowH[75]; $enfermedades = $enfermedades1; }
		if($rowH[76]!=''){ $enfermedades2 = $rowH[76]; $enfermedades = $enfermedades1.', '.$enfermedades2; }
		if($rowH[77]!=''){ $enfermedades3 = $rowH[77]; $enfermedades = $enfermedades1.', '.$enfermedades2.', '.$enfermedades3; }
		if($rowH[78]!=''){ $enfermedades4 = $rowH[78]; $enfermedades = $enfermedades1.', '.$enfermedades2.', '.$enfermedades3.', '.$enfermedades4; }
		if($rowH[79]!=''){ $enfermedades5 = $rowH[79]; $enfermedades = $enfermedades1.', '.$enfermedades2.', '.$enfermedades3.', '.$enfermedades4.', '.$enfermedades5; }
	}

	//APP Cirugías
	if( $rowH[80]=='' and $rowH[81]=='' and $rowH[82]=='' ){ $cirugias = 'INFORMACIÓN NO PROPORCIONADA'; }else { 
		$dataAHF11 = $rowH[80];
		if($rowH[81]!=''){ $dataAHF11 = $dataAHF11.', '.$rowH[81];} if($rowH[82]!=''){ $cirugias = $dataAHF11.', '.$rowH[82];}
	}
	//APP Transfusiones
	if( $rowH[83]==''){ $transfusiones = 'INFORMACIÓN NO PROPORCIONADA'; }else { $transfusiones = $rowH[83];}
	// APP NOTAS 
	if( $rowH[84]=='' ){ $notas_app = 'SIN NOTAS'; }else { $notas_app = $rowH[84]; }

	$app = "<table width='100%'>".
		"<tr><th>ANTECEDENTES PATOLÓGICOS PERSONALES</th></tr>".
	 	"<tr><th style='text-align: left'>Enfermedades</th></tr>".
		"<tr><td>".$enfermedades."</td></tr>".
		"<tr><th style='text-align: left'>Alergias</th></tr>".
	    "<tr><td>".$alergias."</td></tr>".
		"<tr><th style='text-align: left'>Cirugias</th></tr>".
	    "<tr><td>".$cirugias."</td></tr>".
		"<tr><th style='text-align: left'>Número de transfusiones</th></tr>".
	    "<tr><td>".$transfusiones."</td></tr>".
		"<tr><th colspan='3' style='text-align: left'>Notas</th></tr>".
		"<tr><td colspan='3'>".$notas_app."</td></tr>".
		"</table>";

	// AGO 
	if( $rowH[85]!='' ){ $menarca = $rowH[85].' AÑOS'; }else{$menarca = '-';}
	if($rowH[86]!=''){ if($rowH[86]==1){$ritmo='REGULAR';}else{$ritmo='IRREGULAR';} }else{$ritmo='-';}
	if($rowH[87]!=''){ $duracion = $rowH[87].' DÍAS';}else{$duracion = '-';}
	if($rowH[88]!=''){ $fur = $rowH[88];}else{$fur = '-';}
	if($rowH[89]!=''){ $ivsa = 'A LOS '.$rowH[89].' AÑOS';}else{$ivsa ='-';}
	if($rowH[90]!=''){ $gestas = $rowH[90];}else{$gestas='-';}
	if($rowH[91]!=''){ $partos = $rowH[91];}else{$partos = '-';}
	if($rowH[92]!=''){ $cesareas = $rowH[92];}else{$cesareas ='-';}
	if($rowH[93]!=''){ $abortos = $rowH[93];}else{$abortos ='-';}
	if($rowH[94]==1 ){ 
		$anticonceptivos = 'SI'; if($rowH[95]!='' ){ if($rowH[96]!=''){ $tiempoanticon = $rowH[96].' AÑOS'; } $tipoanticon = $rowH[95];
	}
	}else if($rowH[94]==0){$anticonceptivos = 'NO'; $tipoanticon = '-'; $tiempoanticon = '-'; }
	else{$anticonceptivos = '-'; $tipoanticon = '-'; $tiempoanticon ='-';}
	if($rowH[97]!=''){ $notas_ago =$rowH[97];}else{$notas_ago = 'SIN NOTAS';}

	$ago = "<table width='100%'>".
	 	"<tr><th colspan='3'>ANTECEDENTES GINECO-OBSTÉTRICOS</th></tr>".
		"<tr><th style='text-align: left'>Menaca</th><th style='text-align: left'>Ritmo</th><th style='text-align: left'>Duración</th></tr>".
		"<tr><td>".$menarca."</td><td>".$ritmo."</td><td>".$duracion."</td></tr>".
		"<tr><th style='text-align: left'>Fecha última regla</th><th style='text-align: left'>I.V.S.A.</th><th style='text-align: left'>Gestas</th></tr>".
		"<tr><td>".$fur."</td><td>".$ivsa."</td><td>".$gestas."</td></tr>".
		"<tr><th style='text-align: left'>Partos</th><th style='text-align: left'>Cesareas</th><th style='text-align: left'>Abortos</th></tr>".
		"<tr><td>".$partos."</td><td>".$cesareas."</td><td>".$abortos."</td></tr>".
		"<tr><th style='text-align: left'>Anticonceptivos</th><th style='text-align: left'>Tipo</th><th style='text-align: left'>Tiempo de uso</th></tr>".
		"<tr><td>".$anticonceptivos."</td><td>".$tipoanticon."</td><td>".$tiempoanticon."</td></tr>".
		"<tr><th colspan='3' style='text-align: left'>Notas</th></tr>".
		"<tr><td colspan='3'>".$notas_ago."</td></tr>".
		"</table>";

	$historia = $ahf . "<br>" . $apnp . "<br>" . $app . "<br>" . $ago;
	$datos = $alergias.'-{]'.$row[3].'-{]'.$row[2].'-{]'.$row[0].' '.$row[1].'-{]'.$rowM[0].' '.$rowM[1].'-{]'.$signos_v.'-{]'.$abitus.'-{]'.$adicciones.
		'-{]'.$puntuacion_g.'-{]'.$antropometria.'-{]'.$fecha_hora.'-{]'.$rowM[0].' '.$rowM[1].'-{]'.$row[3].'-{]'.$rowM[3].'-{]'.$rowM[4].'-{]'.$row[3].
		'-{]'.$rowM[5].'-{]'.$dia.'-{]'.$mes1.'-{]'.$anio.'-{]'.$hora.'-{]'.$rowVC[0].'-{]'.$rowM[6].'-{]'.$row1s[12].'-{]'.$row1s[13].'-{]'.$row[2].'-{]'.
		$row[4].'-{]'.$rowM[7].'-{]'.$rowVC[1].'-{]'.$rowVC[2].' '.$rowVC[3].'-{]'.$mes.'-{]'.$myFirma.'-{]'.$rowFrts[0].'-{]'.$rowVC[4].'-{]'.$row1s[0].
		'-{]'.$row1s[1].'-{]'.$row1s[3].'-{]'.$row1s[2].'-{]'.$row1s[4].' ºC'.'-{]'.$rowVC[5].'-{]'.$rowVC[6].'-{]'.$rowVC[7].' '.$rowVC[8].'-{]'.$encaNM.
		'-{]'.$encaNM1.'-{]'.$encaNM2.'-{]'.$encaNM3.'-{]'.$logoMedicina.'-{]'.$rowVC[10].'-{]'.$rowVC[11].'-{]'.$rowVC_1[0].'-{]'.$lista.'-{]'.$lista1.
		'-{]'.$historia.'-{]'.$ahf.'-{]'.$apnp.'-{]'.$app.'-{]'.$ago.'-{]'.$feNac .'-{]'. $dx_cont .'-{]'.$md_cont .'-{]'.$row1s[15].'-{]'.$logosA1[0].'-{]'.$logosA1[1] .'-{]'. $logosA1[2] .'-{]'.$logosA1[3] .'-{]'.$logosA1[4].'-{]'.$logosA1[5].'-{]'.$logosA1[6] .'-{]'. $logosA1[7] .'-{]'.$logosA1[8] .'-{]'.$logosA1[9].'-{]'.$logosA1[10].'-{]'.$logosA1[11] .'-{]'. $logosA1[12] .'-{]'.$logosA1[13] .'-{]'.$logosA1[14];
	
	echo $datos;
 	//Cerrar conexión a la Base de Datos
 	mysql_close($horizonte);
?>
