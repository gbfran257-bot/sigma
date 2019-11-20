<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	$idP = sqlValue($_POST["idP"], "int"); $idU = sqlValue($_POST["idU"], "int"); $aleat1 = sqlValue($_POST["aleatorio"], "text");
	$idHospitalizacion = sqlValue($_POST["idH"], "int");
	
	mysql_select_db($database_horizonte, $horizonte);
	$resultDXi = mysql_query("SELECT dx.nombre_di, DATE_FORMAT(n.fecha_nh,'%d/%c/%Y') from diagnosticos dx left join dx_hospital dxh on dxh.id_dx_dxh = dx.id_di left join notas_de_hospital n on n.id_hospitalizacion_nh = dxh.id_hospitalizacion_dxh left join notas_medicas nm on nm.id_nm = n.id_nota_nh where dxh.id_hospitalizacion_dxh = $idHospitalizacion and nm.nombre_nm like '%NOTA DE INGRESO HOSPITALARIO%' and dxh.primario_dxh = 1 limit 1 ", $horizonte) or die (mysql_error());
 	$rowDXi = mysql_fetch_row($resultDXi);
	
	$dx_ingreso = 'DIAGNÓSTICO DE INGRESO: '.$rowDXi[0];
	
	$fecha_ingreso = 'FECHA DE INGRESO: '.$rowDXi[1]; $fecha_egreso = 'FECHA DE EGRESO: '.date('d/m/Y');
	
	$now = date('d/m/Y H:i:s');
	
	$fecha_hora = 'FECHA Y HORA DE ELABORACIÓN: '.$now;
	
	mysql_select_db($database_horizonte, $horizonte);
	$resultAl = mysql_query("SELECT alergia1_hc, alergia2_hc, alergia3_hc, alergia4_hc, alergia5_hc, alergia6_hc from historia_clinica where id_paciente_hc = $idP ", $horizonte) or die (mysql_error());
 	$rowAl = mysql_fetch_row($resultAl);
	
	if($rowAl[0]=='' and $rowAl[1]=='' and $rowAl[2]=='' and $rowAl[3]=='' and $rowAl[4]=='' and $rowAl[5]==''){$alergias='NINGUNA';}
	else{
		if($rowAl[0]!=''){$aler = $rowAl[0];} if($rowAl[1]!=''){$aler = $aler.', '.$rowAl[1];}
		if($rowAl[2]!=''){$aler = $aler.', '.$rowAl[2];} if($rowAl[3]!=''){$aler = $aler.', '.$rowAl[3];}
		if($rowAl[4]!=''){$aler = $aler.', '.$rowAl[4];} if($rowAl[5]!=''){$aler = $aler.', '.$rowAl[5];}
		if($aler[0]==', '){$alergias = substr($aler, 1);}else{$alergias = $aler;}
	}
	
	mysql_select_db($database_horizonte, $horizonte);
 	$result = mysql_query("SELECT concat(p.nombre_p, ' ', p.apaterno_p), p.amaterno_p, sx.cat_sexo, p.fNac_p from pacientes p left join catalogo_sexos sx on sx.id_sexo = p.sexo_p where p.id_p = $idP ", $horizonte) or die (mysql_error());
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
	$resultM = mysql_query("SELECT concat(titulo_u, ' ',nombre_u, ' ', apaterno_u), amaterno_u, concat('CÉDULA PROFESIONAL ',cedulaProfesional_u) from usuarios where id_u = $idU ", $horizonte) or die (mysql_error());
 	$rowM = mysql_fetch_row($resultM);
	
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
		
	$datos = $alergias.'-{]EDAD: '.$row[3].'-{]SEXO: '.$row[2].'-{]'.$row[0].' '.$row[1].'-{]'.$rowM[0].' '.$rowM[1].' '.$rowM[2].'-{]'.$signos_v.'-{]'.$abitus.'-{]'.$adicciones.'-{]'.$puntuacion_g.'-{]'.$antropometria.'-{]'.$fecha_hora.'-{]'.$dx_ingreso.'-{]'.$fecha_ingreso.'-{]'.$fecha_egreso;
	
	echo $datos;
 	//Cerrar conexión a la Base de Datos
 	mysql_close($horizonte);
?>