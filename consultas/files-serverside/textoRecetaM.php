<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	$idNM = sqlValue($_POST["idNM"], "int"); $idC = sqlValue($_POST["idC"], "int");

	mysql_select_db($database_horizonte, $horizonte);
	$result = mysql_query("SELECT nota_nm from notas_medicas where id_nm = $idNM ", $horizonte) or die (mysql_error());
	$row = mysql_fetch_row($result);
 
 mysql_select_db($database_horizonte, $horizonte); 
 $resultC = mysql_query("SELECT v.salvado_vc, v.id_paciente_vc, v.motivo_visita_vc, DATE_FORMAT(v.fechaEdo2_e,'%d/%c/%Y %H:%i'), concat(m.nombre_u,' ',m.apaterno_u), m.amaterno_u, ti.abreviacion_ti, m.cedulaProfesional_u, t.concepto_to, v.referencia_vc, e.nombre_especialidad, m.cedulaProfesionalE_u, un.nombre_e, un.id_e, su.id_su from venta_conceptos v left join usuarios m on m.id_u = v.usuarioEdo2_e left join titulos ti on ti.id_ti = m.titulo_u left join conceptos t on t.id_to = v.id_concepto_es left join especialidades e on e.id_es = m.especialidad_u left join catalogo_escuelas un on un.id_e = m.universidad_u left join orden_venta o on o.referencia_ov = v.referencia_vc left join sucursales su on su.id_su = o.sucursal_ov where v.id_vc = $idC", $horizonte) or die (mysql_error());
 $rowC = mysql_fetch_row($resultC); $idPac = sqlValue($rowC[1], "int"); $idUniv = sqlValue($rowC[13], "int"); $idSucursal = sqlValue($rowC[14], "int");
 
 mysql_select_db($database_horizonte, $horizonte); 
 $resultH = mysql_query("SELECT a1.adiccion_ca, i1.inicio_ci, f1.frecuencia_cf, a2.adiccion_ca, i2.inicio_ci, f2.frecuencia_cf, a3.adiccion_ca, i3.inicio_ci, f3.frecuencia_cf from historia_clinica h left join catalogo_adicciones a1 on a1.id_ca = h.adiccion1 left join catalogo_inicios i1 on i1.id_ci = h.inicio_adiccion1 left join catalogo_frecuencias f1 on f1.if_cf = h.frecuencia_adiccion1 left join catalogo_adicciones a2 on a2.id_ca = h.adiccion2 left join catalogo_inicios i2 on i2.id_ci = h.inicio_adiccion2 left join catalogo_frecuencias f2 on f2.if_cf = h.frecuencia_adiccion2 left join catalogo_adicciones a3 on a3.id_ca = h.adiccion3 left join catalogo_inicios i3 on i3.id_ci = h.inicio_adiccion3 left join catalogo_frecuencias f3 on f3.if_cf = h.frecuencia_adiccion3 where h.id_paciente_hc = $idPac order by h.id_hc desc limit 1", $horizonte) or die (mysql_error());
 $rowH = mysql_fetch_row($resultH);
 
 $conH = 0;
 if($rowH[0]!=NULL or $rowH[0]!=''){ $adiccion1 = 'ADICCIÓN '.$rowH[2].' '.$rowH[0].' '.$rowH[1]; $conH++; }
 if($rowH[3]!=NULL or $rowH[3]!=''){ $adiccion2 = ', ADICCIÓN '.$rowH[5].' '.$rowH[3].' '.$rowH[4]; $conH++; }
 if($rowH[6]!=NULL or $rowH[6]!=''){ $adiccion3 = ', ADICCIÓN '.$rowH[8].' '.$rowH[6].' '.$rowH[7]; $conH++; }
 
 if($conH==0){ $adicciones = 'Antecedentes tabáquicos, alcohólicos y sustancias psicoactivas:<br><br>'; }
 else{$adicciones = $adiccion1.' '.$adiccion2.' '.$adiccion3.'<br><br>';}
 
 mysql_select_db($database_horizonte, $horizonte); 
 $resultS = mysql_query("SELECT s.t_sv, s.a_sv, s.fr_sv, s.fc_sv, s.temperatura_sv, s.oximetria_sv, t1.nombre_tg, t2.nombre_tg, t3.nombre_tg, s.a_ocular_sv, s.r_verbal, s.r_motriz, s.peso_sv, s.talla_sv, s.a_ocular_sv+s.r_verbal+s.r_motriz from signos_vitales s left join tabla_glasgow t1 on t1.valor_tg = s.a_ocular_sv and t1.tipo_tg = 1 left join tabla_glasgow t2 on t2.valor_tg = s.r_verbal and t2.tipo_tg = 2 left join tabla_glasgow t3 on t3.valor_tg = s.r_motriz and t3.tipo_tg = 3 where s.id_paciente_sv = $idPac order by s.id_sv desc limit 1", $horizonte) or die (mysql_error());
 $rowS = mysql_fetch_row($resultS);
 if($rowS[9]!=0 or $rowS[9]!=NULL){  $aocu = 'abertura ocular: '.$rowS[6]; }else{$aocu = '';}
 if($rowS[10]!=0 or $rowS[10]!=NULL){  $rverb = ', respuesta verbal: '.$rowS[7]; }else{$rverb = '';}
 if($rowS[11]!=0 or $rowS[11]!=NULL){  $rmotr = ', respuesta motriz: '.$rowS[8]; }else{$rmotr = '';}
 if($rowS[10]>0){ $puntuacion_g = 'Neurológicamente con una puntuación de Glasglow de: '.$rowS[14].'<br>'; }
 
 $abitus = $aocu.$rverb.$rmotr;
 
 $antropometria = 'Peso: '.$rowS[12].' Kg Talla: '.$rowS[13].' m';
 
 if($rowS[5] != NULL or $rowS[5] != ''){ $oxi_sv = "oximetría de pulso (".$rowS[5]."% SaO2)";} else{$oxi_sv = "";}
 
 mysql_select_db($database_horizonte, $horizonte); 
 $resultP = mysql_query("SELECT sexo_p, fNac_p, concat(nombre_p,' ',apaterno_p), amaterno_p, DATE_FORMAT(fNac_p,'%d/%c/%Y') from pacientes where id_p = $idPac", $horizonte) or die (mysql_error());
 $rowP = mysql_fetch_row($resultP);
 
 //para la edad
 $fecha1 = new DateTime($rowP[1]); $fecha2 = new DateTime(date("Y-m-d H:i:s")); $fecha = $fecha1->diff($fecha2);
 //printf('%d AÑOS %d MESES %d DÍAS %d HORAS %d MINUTOS', $fecha->y, $fecha->m, $fecha->d, $fecha->h, $fecha->i);
 $anos=$fecha->y; $meses=$fecha->m; $dias=$fecha->d; $horas=$fecha->h; $minutos=$fecha->i;
 if($anos>0){$rowP[1]=$anos." AÑOS";}
 if($anos<1){
	if($meses<=2 and $meses>=1){$rowP[1]=$meses." MES(ES) ".$dias." DÍA(S)";}
	if($meses>=3){$rowP[1]=$meses." MES(ES) ";}
	if($meses==0){$rowP[1]=$dias." DÍA(S)";}
	if($meses==0 and $dias<=1){$rowP[1]=$dias." DÍA(S) ".$horas." HORA(S)";}
	if($meses==0 and $dias<1){$rowP[1]=$horas." HORA(S) ".$minutos." MINUTO(S)";}
 } 
 if($anos>150 or $anos<0){$rowP[1]="DESCONOCIDA";}
 
 if($rowP[0]==1){$sexo = 'FEMENINO';} else{$sexo = 'MASCULINO';}
 
 $tratamiento = '';
 $medico = $rowC[6].' '.$rowC[4].' '.$rowC[5];
 
 if($_POST["idNM"]!=0){
	 $tabla = $row[0];
 }else{
	 $tabla = '
	<table id="p_contenido" width="100%" border="0" cellspacing="3" cellpadding="0">
		<tr>
			<td colspan="2" style="font-size:10pt;" align="center" valign="top">'.$rowC[12].'<br>RECETA '.$rowC[16].'</td>
			<td style="font-size:10pt;" width="33%" align="center">'.$si0.'</td>
			</tr>
		<tr>
			<td style="font-size:10pt;">NOMBRE: '.$rowP[2].' '.$rowP[3].'</td>
			<td style="font-size:10pt;" width="33%">SEXO: '.$sexo.' EDAD: '.$rowP[1].'</td>
			<td style="font-size:10pt;" width="33%">FECHA: '.$rowC[3].'</td>
		</tr>
		<tr>
			<td style="font-size:7pt;" width="80%" colspan="3">SIGNOS VITALES: TENSIÓN ARTERIAL ('.$rowS[0].'/'.$rowS[1].'mmHg), FRECUENCIA CARDIACA ('.$rowS[3].'xmin), FRECUENCIA RESPIRATORIA ('.$rowS[2].'xmin), TEMPERATURA ('.$rowS[4].' ºC)</td>
		</tr>
		<tr>
			<td valign="top" colspan="3" style="border-top:1px none black; font-size:10pt; border-bottom:1px none black;" align="justify"></td>
		</tr>
		<tr>
			<td></td>
			<td colspan="2" style="font-size:10pt;" align="center" height="70" valign="bottom">'.$medico.'<br>'.$rowC[10].' CP '.$rowC[7].'</td>
		</tr>
		<tr><td colspan="3" style="font-size:7pt;" align="center"><br>'.$rowC[16].'. '.$rowC[17].'. TELÉFONO: '.$rowC[18].'</td></tr>
	</table>
	';
	 
	 mysql_select_db($database_horizonte, $horizonte);
	 $resultR2 = mysql_query("SELECT formato_nm_su from sucursales where id_su = $idSucursal", $horizonte);
	 $rowR2 = mysql_fetch_row($resultR2);

	 if($rowR2[0]==''){
		//Entonces checamos si hay un formato desde la configuración principal
		mysql_select_db($database_horizonte, $horizonte);
		$resultR3 = mysql_query("SELECT formato_nm_cf from configuracion order by id_cf desc limit 1", $horizonte);
		$rowR3 = mysql_fetch_row($resultR3);

		if($rowR2[0]==''){$tabla = '';}else{$tabla = $rowR3[0];}
	 }else{ $tabla = $rowR2[0];}
 }
	
	echo $tabla;
	
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>

