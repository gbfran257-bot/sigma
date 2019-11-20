<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idP = sqlValue($_POST["idP"], "int");
 $idC = sqlValue($_POST["idC"], "int");
 
 mysql_select_db($database_horizonte, $horizonte); 
 $resultC = mysql_query("SELECT v.salvado_vc, v.id_paciente_vc, v.motivo_visita_vc, DATE_FORMAT(v.fechaEdo2_e,'%d/%c/%Y %H:%i'), concat(m.nombre_u,' ',m.apaterno_u), m.amaterno_u, ti.abreviacion_ti, m.cedulaProfesional_u, t.concepto_to, v.referencia_vc, e.nombre_especialidad, m.cedulaProfesionalE_u, un.nombre_e, un.id_e, esp.nombre_e, esp.id_e, su.nombre_su, concat(su.calle_su, ' COLONIA ', su.colonia_su, ', ', su.ciudad_su, ' ', su.estado_su), su.telefono_su from venta_conceptos v left join usuarios m on m.id_u = v.usuarioEdo2_e left join conceptos t on t.id_to = v.id_concepto_es left join especialidades e on e.id_es = m.especialidad_u left join catalogo_escuelas un on un.id_e = m.universidad_u left join catalogo_escuelas esp on esp.id_e = m.universidad_e_u left join titulos ti on ti.id_ti = m.titulo_u left join orden_venta o on o.referencia_ov = v.referencia_vc left join sucursales su on su.id_su = o.sucursal_ov where v.id_vc = $idC", $horizonte) or die (mysql_error());
 $rowC = mysql_fetch_row($resultC); $idPac = sqlValue($rowC[1], "int"); $idUniv = sqlValue($rowC[13], "int"); $idUnivE = sqlValue($rowC[15], "int");
 
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
 
 $medico = $rowC[6].' '.$rowC[4].' '.$rowC[5];
 if($rowC[11]!=''){$rowC[11]='CÉD DE ESP: '.$rowC[11];}
 
 mysql_select_db($database_horizonte, $horizonte); 
 $resultP = mysql_query("SELECT sexo_p, fNac_p, concat(nombre_p,' ',apaterno_p), amaterno_p, DATE_FORMAT(fNac_p,'%d/%c/%Y') from pacientes where id_p = $idP", $horizonte) or die (mysql_error());
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
 
 	$aleatorio = sqlValue($_POST["noAleatorio"], "text"); $i = 0;
	
	 mysql_select_db($database_horizonte, $horizonte); 
	 $resultL = mysql_query("SELECT id_do,ext_do from documentos where nombre_do = 'LOGOTIPO' and tipo_quien_do = 5 and id_quien_do = $idUniv", $horizonte) or die (mysql_error());
	 $rowL = mysql_fetch_row($resultL);
	 
	 $fileL = '../../escuelas/logotipos/files/'.$rowL[0].'.'.$rowL[1];
	 if(file_exists($fileL)){ $si='<img src="escuelas/logotipos/files/'.$rowL[0].'.'.$rowL[1].'" height="70">'; }else{ $si=''; }
	 
	 mysql_select_db($database_horizonte, $horizonte); 
	 $resultL0 = mysql_query("SELECT id_do,ext_do from documentos where nombre_do = 'LOGOTIPO' and tipo_quien_do = 5 and id_quien_do = $idUnivE", $horizonte) or die (mysql_error());
	 $rowL0 = mysql_fetch_row($resultL0);
	 
	 $fileL0 = '../escuelas/logotipos/files/'.$rowL0[0].'.'.$rowL0[1];
	 if(file_exists($fileL0)){ $si0='<img src="escuelas/logotipos/files/'.$rowL0[0].'.'.$rowL0[1].'" height="70">'; }
	 else{//Si no hay archivo de escuela de especialidad ponemos el logo general
		$si0='<img src="imagenes/generales/logo_medicina.png" height="70">';
	 }
	
	if($si==''){//NO hay logo de escuela
		$lista = '
		<table id="p_contenido" width="100%" border="0" cellspacing="3" cellpadding="0">
			<tr>
				<td colspan="2" style="font-size:9pt;" align="center" valign="top">'.$rowC[12].'<br>RECETA '.$rowC[16].'</td>
				<td style="font-size:9pt;" width="33%" align="center">'.$si0.'</td>';
	}else{//SI hay logo de escuela
		$lista = '
		<table id="p_contenido" width="100%" border="0" cellspacing="3" cellpadding="0">
			<tr>
				<td style="font-size:9pt;" width="33%" align="center">'.$si.'</td>
				<td style="font-size:9pt;" align="center">'.$rowC[12].'<br>RECETA '.$rowC[16].'</td>
				<td style="font-size:9pt;" width="33%" align="center">'.$si0.'</td>';
	}
	$lista = $lista.'
			</tr>
			<tr valign="bottom">
				<td style="font-size:9pt;" height="30">NOMBRE: '.$rowP[2].' '.$rowP[3].'</td>
				<td style="font-size:9pt;" width="33%" height="30">SEXO: '.$sexo.' EDAD: '.$rowP[1].'</td>
				<td style="font-size:9pt;" width="33%" height="30">FECHA: '.$rowC[3].'</td>
			</tr>
			<tr>
				<td style="font-size:7pt;" height="30" colspan="3" valign="top">SIGNOS VITALES: TENSIÓN ARTERIAL ('.$rowS[0].'/'.$rowS[1].'mmHg), FRECUENCIA CARDIACA ('.$rowS[3].'xmin), FRECUENCIA RESPIRATORIA ('.$rowS[2].'xmin), TEMPERATURA ('.$rowS[4].' ºC)<br><br></td>
			</tr>
		  '; 
	
	mysql_select_db($database_horizonte, $horizonte);
	$result = mysql_query("SELECT m.id_med_mr, m.id_med_mr, m.id_med_mr from medicamentos_receta m left join conceptos c on c.id_to = m.id_med_mr where m.id_co_mr = $idC and c.id_area_to = 61 and c.id_departamento_to = 3 and c.id_tipo_concepto_to = 5", $horizonte) or die (mysql_error()); 
	while ( $row = mysql_fetch_row($result) ){
		$i++;
		mysql_select_db($database_horizonte, $horizonte); 
 		$resultEP = mysql_query("SELECT c.concepto_to, m.nombre_generico_med, m.cantidad_med, m.descripcion_med, c.descripcion_to from medicamentos m left join conceptos c on c.id_medicamento_g = m.id_med where c.id_to = $row[0]", $horizonte) or die (mysql_error());
 		$rowEP = mysql_fetch_row($resultEP);
		
		$nameC = $row[0].$i; //$idC = $row[2].$i;
		$lista = $lista.'<tr class="tableMeds"><td colspan="3" align="left" style="font-size:9pt;">'.$i.'.- <span style="text-decoration:underline;">'.ucfirst(strtolower($rowEP[0])).'</span> ('.ucfirst(strtolower($rowEP[1])).') '.ucfirst(strtolower($rowEP[2])).' '.ucfirst(strtolower($rowEP[3])).'</td></tr>';
		$lista = $lista.'<tr class="tableMeds"><td colspan="3" align="left" style="font-size:9pt;">&nbsp;&nbsp;'.ucfirst(strtolower($rowEP[4])).' </td></tr>';
	} 
	$lista = $lista.'
		  <tr>
				<td></td>
				<td colspan="2" style="font-size:9pt;" align="center" height="70" valign="bottom">'.$medico.'<br>'.$rowC[10].' CP '.$rowC[7].'</td>
			</tr>';
	if($rowC[18]!=''){//Hay teléfono de sucursal
		$lista = $lista.'<tr><td colspan="3" style="font-size:7pt;" align="center"><br>'.$rowC[16].'. '.$rowC[17].'. TELÉFONO: '.$rowC[18].'</td></tr>';
	}else{//No hay teléfono de sucursal
		$lista = $lista.'<tr><td colspan="3" style="font-size:7pt;" align="center"><br>'.$rowC[16].'. '.$rowC[17].'</td></tr>';
	}
	$lista = $lista.'
		</table>
	';

 mysql_select_db($database_horizonte, $horizonte); 
 $resultC = mysql_query("SELECT count(id_mr) from medicamentos_receta where id_co_mr = $idC", $horizonte) or die (mysql_error());
 $rowC = mysql_fetch_row($resultC);
 
 if($rowC[0]==0){ echo $rowC[0].';}{;'; }
 else{ echo $rowC[0].';}{;'.$lista; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>