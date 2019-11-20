<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	$idE = sqlValue($_POST["idVC"], "int"); $idP = sqlValue($_POST["idP"], "int"); $idU=sqlValue($_POST["idU"],"int");

	mysql_select_db($database_horizonte, $horizonte);
	$result = mysql_query("SELECT v.referencia_vc, v.interpretacion_vc, v.nota_interpretacion, date_format(v.fecha_venta_vc,'%d/%c/%Y'), v.id_concepto_es, v.nota_radiologo_vc, v.birad_vc, v.id_personal_medico_vc, v.usuarioEdo5_e, o.sucursal_ov from venta_conceptos v left join orden_venta o on o.referencia_ov = v.referencia_vc where v.id_vc = $idE ", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result); $claveE = sqlValue($row[4], "int"); $id_sucursal = sqlValue($row[9], "int");

	$result4 = mysql_query("SELECT u.nombre_u, u.apaterno_u, u.amaterno_u, u.cedulaProfesional_u, u.id_u, u.sexo_u, t.abreviacion_ti, u.firma_u, u.temporal_u from usuarios u left join titulos t on t.id_ti = u.titulo_u where u.id_u = $idU ", $horizonte) or die (mysql_error());
 	$row4 = mysql_fetch_row($result4); $tempU = sqlValue($row4[8], "text"); //echo $row4[7];
	$medicoAutoriza = $row4[6]." ".$row4[0]." ".$row4[1]." ".$row4[2]; $tempU = sqlValue($row4[8], "text");
	
	$resultFt = mysql_query("SELECT count(id_do) from documentos where aleatorio_do = $tempU and firma_do = 1 ", $horizonte) or die (mysql_error());
 	$rowFt = mysql_fetch_row($resultFt);
	
	if($rowFt[0]>0){
		mysql_select_db($database_horizonte, $horizonte); 
		$resultDo = mysql_query("SELECT ext_do, id_do from documentos where aleatorio_do = $tempU and firma_do = 1 limit 1", $horizonte) or die (mysql_error());
		$rowDo = mysql_fetch_row($resultDo);
		$myFirma = '<img src="usuarios/documentos/files/'.$rowDo[1].'.'.$rowDo[0].'" height="90" width="" style=" border-style:none;">';
	 }else{$myFirma = '';}
	
	$result3=mysql_query("SELECT concepto_to, id_area_to, formato from conceptos where id_to = $claveE", $horizonte) or die (mysql_error());
 	$row3 = mysql_fetch_row($result3);
	$areaE = sqlValue($row3[1], "int");
	
	mysql_select_db($database_horizonte, $horizonte);
	$result2 = mysql_query("SELECT nombre_u, apaterno_u, amaterno_u, titulo_u, idSucursal_u, cedulaProfesional_u, id_u, sexo_u, firma_u, temporal_u from usuarios where id_u = $row[7] ", $horizonte) or die (mysql_error());
 	$row2 = mysql_fetch_row($result2);
	
	if($row2[0]=='A' and $row2[1] == 'QUIEN'){ $miMedico =$row2[0]." ".$row2[1]." ".$row2[2];}
	else{$miMedico = $row2[3]." ".$row2[0]." ".$row2[1]." ".$row2[2];}
	
	mysql_select_db($database_horizonte, $horizonte);
	$result1 = mysql_query("SELECT p.fNac_p, p.sexo_p, concat(p.nombre_p, ' ', p.apaterno_p), p.amaterno_p, date_format(p.fNac_p,'%d/%c/%Y'), s.cat_sexo from pacientes p left join catalogo_sexos s on s.id_sexo = p.sexo_p where p.id_p = $idP ", $horizonte) or die (mysql_error());
 	$row1 = mysql_fetch_row($result1);
	
	mysql_select_db($database_horizonte, $horizonte);
	$result1x = mysql_query("SELECT concepto_to, formato from conceptos where id_to = $row[4] ",$horizonte) or die (mysql_error());
 	$row1x = mysql_fetch_row($result1x);
	
	//para la edad
	$fecha1 = new DateTime($row1[0]); $fecha2 = new DateTime(date("Y-m-d H:i:s")); $fecha = $fecha1->diff($fecha2);
	//printf('%d AÑOS %d MESES %d DÍAS %d HORAS %d MINUTOS', $fecha->y, $fecha->m, $fecha->d, $fecha->h, $fecha->i);
	$anos=$fecha->y; $meses=$fecha->m; $dias=$fecha->d; $horas=$fecha->h; $minutos=$fecha->i;
	if($anos>0){$row1[0]=$anos." AÑOS";}
	if($anos<1){
		if($meses<=2 and $meses>=1){$row1[0]=$meses." MES(ES) ".$dias." DÍA(S)";}
		if($meses>=3){$row1[0]=$meses." MES(ES) ";}
		if($meses==0){$row1[0]=$dias." DÍA(S)";}
		if($meses==0 and $dias<=1){$row1[0]=$dias." DÍA(S) ".$horas." HORA(S)";}
		if($meses==0 and $dias<1){$row1[0]=$horas." HORA(S) ".$minutos." MINUTO(S)";}
	} 
	if($anos>150 or $anos<0){$row1[0]="DESCONOCIDA";}
	//para el sexo
	switch($row1[1]){
		case 1: $row1[1] = "FEMENINO"; break;
		case 2: $row1[1] = "MASCULINO"; break;
		case 3: $row1[1] = "AMBIGUO"; break;
		case 4: $row1[1] = "NO APLICA"; break;
		case 99: $row1[1] = "SIN ASIGNACIÓN"; break;
	}
	$nombre = $row1[2].' '.$row1[3];
	
	//<strong>Técnica:</strong><br><br><br><strong>Hallazgos:</strong>
	//<tr> <td class="" valign="top" colspan="2" style="padding-top:3pt; padding-bottom:5pt;" id="misDXEI" align="justify"><strong>Diagnósticos:</strong><br><br></td> </tr>

	mysql_select_db($database_horizonte, $horizonte); 
	$resultR2 = mysql_query("SELECT formato from conceptos where id_to = $claveE", $horizonte);
	$rowR2 = mysql_fetch_row($resultR2);

	if($rowR2[0]==''){
		mysql_select_db($database_horizonte, $horizonte); 
		$resultR = mysql_query("SELECT formato_im_su from sucursales where id_su = $id_sucursal", $horizonte);
		$rowR = mysql_fetch_row($resultR);

		if($rowR[0]==''){
			//Entonces checamos si hay un formato desde la configuración principal
			mysql_select_db($database_horizonte, $horizonte); 
			$resultR1 = mysql_query("SELECT formato_im_cf from configuracion order by id_cf desc limit 1", $horizonte);
			$rowR1 = mysql_fetch_row($resultR1);

			if($rowR[0]==''){
				$tabla = '
					<table id="p_contenido" width="100%" border="0" cellspacing="3" cellpadding="0" style="width:100%;"> 
					  <tr class="mceNonEditable1" style="font-size:10pt;">
						<td width="20%" nowrap height="" valign="bottom"> <span style="text-decoration:underline;">PACIENTE:</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
						<td class="encaH" width="" align="left" valign="bottom">'.$row1[2].' '.$row1[3].'</td> 
					  </tr> 
					  <tr class="mceNonEditable1" style="font-size:10pt;"> 
						<td style="text-decoration:underline;">MED/TRAT.:</td> <td class="myMedicoP" align="left">'.$miMedico.'</td> 
					  </tr> 
					  <tr class="mceNonEditable1" style="font-size:10pt;">
						<td style="text-decoration:underline;" nowrap>DX. ENVÍO:</td> <td align="left" nowrap>EN ESTUDIO</td> 
					  </tr>
					  <tr class="mceNonEditable1" style="font-size:10pt;">
						<td style="text-decoration:underline;" nowrap>F E C H A:</td> <td class="" colspan="2" align="left">'.$row[3].'</td> 
					  </tr> 
					  <tr> <td id="misDXEI" valign="top" height="670" colspan="2" style="padding-top:3pt; padding-bottom:5pt; font-size:10pt;" align="justyfi"></td> </tr>
					  <tr> <td id="firmaDR" align="center" height="80" colspan="2" style=""><br><br> '.$myFirma.' </td> </tr> 
					  <tr> <td nowrap align="center" colspan="2" style="font-size:10pt;">'.$medicoAutoriza.'</td> </tr> 
					  <tr> <td nowrap align="center" colspan="2" style="font-size:10pt;">MEDICO RADIÓLOGO</td> </tr> 
					</table>
				';
			}else{//Hay formato de configuración
				$tabla = $rowR1[0];
			}
		}else{//Hay formato de la sucursal
			$tabla = $rowR[0];
		} 
	}else{//Hay formato individual del estudio
		$tabla = $rowR2[0];
	}
	
	//Si el estudio tiene machote, lo ponemos
	/*if($row3[2] != '' and $row3[2] != NULL){ $macho = $row3[2]; }else{ $macho = ""; }
	
	$tabla = '
		<table id="p_contenido" width="100%" border="0" cellspacing="3" cellpadding="0" style="width:100%;"> 
		  <tr class="mceNonEditable1" style="font-size:12pt;">
			<td width="20%" nowrap height="" valign="bottom"> <span style="text-decoration:underline;">PACIENTE:</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
			<td class="encaH" width="" align="left" valign="bottom">'.$row1[2].' '.$row1[3].'</td> 
		  </tr> 
		  <tr class="mceNonEditable1" style="font-size:12pt;"> 
			<td style="text-decoration:underline;">MED/TRAT.:</td> <td class="myMedicoP" align="left">'.$miMedico.'</td> 
		  </tr> 
		  <tr class="mceNonEditable1" style="font-size:12pt;">
			<td style="text-decoration:underline;" nowrap>DX. ENVÍO:</td> <td align="left" nowrap>EN ESTUDIO</td> 
		  </tr>
		  <tr class="mceNonEditable1" style="font-size:12pt;">
			<td style="text-decoration:underline;" nowrap>F E C H A:</td> <td class="" colspan="2" align="left">'.$row[3].'</td> 
		  </tr> 
		  <tr> <td id="misDXEI" valign="top" height="670" colspan="2" style="padding-top:3pt; padding-bottom:5pt; font-size:13pt;" align="justyfi">'.$macho.'</td> </tr>
		  <tr> <td id="firmaDR" align="center" height="80" colspan="2" style=""><br><br> '.$myFirma.' </td> </tr> 
		  <tr> <td nowrap align="center" colspan="2" style="font-size:12pt;">'.$medicoAutoriza.'</td> </tr> 
		  <tr> <td nowrap align="center" colspan="2" style="font-size:12pt;">MEDICO RADIÓLOGO</td> </tr> 
		</table>
	';*/
	
	$datos = $nombre.'*}{-'.$row[0].'*}{-'.$row1[0].'*}{-'.$row1[1].'*}{-'.$row[3].'*}{-'.$row1x[0].'*}{-'.$row1x[1].'*}{-'.$row[5].'*}{-'.$row[6].'*}{-'.$row[1].'*}{-'.$row[2].'*}{-'.$tabla.'*}{-'.$row3[0];
	
echo $datos;
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>