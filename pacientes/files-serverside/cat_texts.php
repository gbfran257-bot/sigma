<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	$idP = sqlValue($_POST["idP"], "int"); $idU = sqlValue($_POST["idU"], "int");
	
	mysql_select_db($database_horizonte, $horizonte);
 	$resultTS = mysql_query("SELECT s.tipo_sangre from catalogo_tipo_sangre s left join pacientes p on p.tSanguineo_p = s.id_tipo_sangre where p.id_p = $idP ", $horizonte) or die (mysql_error()); 
	$rowTS = mysql_fetch_row($resultTS);
	
	mysql_select_db($database_horizonte, $horizonte);
 	$resultU = mysql_query("SELECT p.idSucursal_u from usuarios p where p.id_u = $idU ", $horizonte) or die (mysql_error()); 
	$rowU = mysql_fetch_row($resultU);
	$idSucursalU = sqlValue($rowU[0], "int");
	
	mysql_select_db($database_horizonte, $horizonte); 
	$resultEU = mysql_query("SELECT estado_su, municipio_su, nombre_su from sucursales where id_su = $idSucursalU limit 1", $horizonte) or die (mysql_error());
	$rowEU = mysql_fetch_row($resultEU); $nombreSucursal = $rowEU[2];
	 	 
	$fecha_completa = $rowEU[1].', '.$rowEU[0].' A '.date('d/m/Y');
	
	$fecha_egreso = 'FECHA DE EGRESO: '.date('d/m/Y');
	
	$now = date('d/m/Y H:i:s');
	$fecha_actual = date('d/m/Y');
	
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
 	$result = mysql_query("SELECT concat(p.nombre_p, ' ', p.apaterno_p), p.amaterno_p, sx.cat_sexo, p.fNac_p, p.tParticular_p, p.entidadFederativa_p, p.municipio_p, p.colonia_p, p.cp_p, p.calle_p, p.id_p, DATE_FORMAT(p.fNac_p,'%d/%c/%Y'), p.entidad_nacimiento_p from pacientes p left join catalogo_sexos sx on sx.id_sexo = p.sexo_p where p.id_p = $idP ", $horizonte) or die (mysql_error()); $row = mysql_fetch_row($result); $tel_parti = $row[4];
	$idEstadoP = sqlValue($row[5], "int"); $idMunicipioP = sqlValue($row[6], "int"); $idColoniaP = sqlValue($row[7], "int");
	$escolaridadP = $row[10]; $fnacP = $row[11]; $historia_clinica = $row[10]; $idEstadoNP = sqlValue($row[12], "int");
	$religionP = $row[10];
	
	mysql_select_db($database_horizonte, $horizonte); 
	$resultEPN = mysql_query("SELECT d_estado from mexico where id_mx = $idEstadoNP limit 1", $horizonte) or die (mysql_error());
	$rowEPN = mysql_fetch_row($resultEPN);
	
	mysql_select_db($database_horizonte, $horizonte); 
	$resultEP = mysql_query("SELECT d_estado from mexico where id_mx = $idEstadoP limit 1", $horizonte) or die (mysql_error());
	$rowEP = mysql_fetch_row($resultEP);
	 
	mysql_select_db($database_horizonte, $horizonte); 
	$resultMP = mysql_query("SELECT d_municipio from mexico where id_mx = $idMunicipioP limit 1", $horizonte) or die (mysql_error());
	$rowMP = mysql_fetch_row($resultMP);
	 
	mysql_select_db($database_horizonte, $horizonte); 
	$resultCP = mysql_query("SELECT d_asenta from mexico where id_mx = $idColoniaP limit 1", $horizonte) or die (mysql_error());
	$rowCP = mysql_fetch_row($resultCP);
	 
	$direccionP = 'CALLE '.$row[9].' COLONIA '.$rowCP[0].', '.$rowMP[0].', '.$rowEP[0];
	$entidadNacimientoP = $rowEPN[0];
	
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
 	else{$adicciones = $adiccion1.' '.$adiccion2.' '.$adiccion3;}//$
		
	$datos = $alergias.'-{]'.$adicciones.'-{]'.$tel_parti.'-{]'.$direccionP.'-{]EDAD: '.$row[3].'-{]'.$escolaridadP.'-{]'.$fnacP.'-{]'.$fecha_actual.'-{]'.$fecha_completa.'-{]'.$historia_clinica.'-{]'.$entidadNacimientoP.'-{]'.$row[0].' '.$row[1].'-{]'.$antropometria.'-{]'.$nombreSucursal.'-{]'.$religionP.'-{]SEXO: '.$row[2].'-{]'.$rowTS[0];
	
	echo $datos;
 	//Cerrar conexión a la Base de Datos
 	mysql_close($horizonte);
?>