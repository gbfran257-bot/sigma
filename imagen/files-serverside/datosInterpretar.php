<?php
require("../../Connections/horizonte.php");
require("../../Connections/ipacs.php");
require("../../funciones/php/values.php");

 $idP=sqlValue($_POST["idP"],"int"); $idU=sqlValue($_POST["idU"],"int"); $idE = sqlValue($_POST["idE"], "int");
 $host = $_POST["h"];

	mysql_select_db($database_horizonte, $horizonte);
	$result = mysql_query("SELECT v.referencia_vc, v.interpretacion_vc, v.nota_interpretacion, date_format(v.fecha_venta_vc,'%d/%m/%Y'), v.id_paciente_vc, v.id_personal_medico_vc, v.id_concepto_es, v.usuarioEdo5_e, v.contador_vc, c.id_area_to, v.nota_radiologo_vc, v.usuarioEdo5_e, DATE_FORMAT(v.fecha_venta_vc,'%Y%m%d'), v.usuarioEdo5_e, DATE_FORMAT(v.fecha_venta_vc,'%Y%m%d'), o.sucursal_ov, v.birad_vc, s.nombre_su, s.id_su, concat(s.id_su,'.',s.id_su), v.id_pacs, DATE_FORMAT(v.fecha_venta_vc,'%Y-%m-%d') from venta_conceptos v left join conceptos c on c.id_to = v.id_concepto_es left join orden_venta o on o.referencia_ov = v.referencia_vc left join sucursales s on s.id_su = o.sucursal_ov where v.id_vc = $idE ", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result);

 $claveE = sqlValue($row[6], "int");
 $ref = sqlValue($row[0], "text");
 $idUautoriza = sqlValue($row[7], "int");
 $idUmedico = sqlValue($row[5], "int");
	
	mysql_select_db($database_horizonte, $horizonte); //Membrete encabezado
 	$resultMNE = mysql_query("SELECT count(id_do), id_do, ext_do from documentos where id_quien_do = $row[15] and que_es_do = 'MEMBRETE RESULTADOS IMAGENOLOGIA' and tipo_quien_do = 2 and nombre_do = 'ENCABEZADO'", $horizonte) or die (mysql_error());
 	$rowMNE = mysql_fetch_row($resultMNE);
 
 	mysql_select_db($database_horizonte, $horizonte); //Membrete pie
 	$resultMNP = mysql_query("SELECT count(id_do), id_do, ext_do from documentos where id_quien_do = $row[15] and que_es_do = 'MEMBRETE RESULTADOS IMAGENOLOGIA' and tipo_quien_do = 2 and nombre_do = 'PIE'", $horizonte) or die (mysql_error());
 	$rowMNP = mysql_fetch_row($resultMNP);
	
	//checamos si el estudio es una masto
	mysql_select_db($database_horizonte, $horizonte);
	$resultMa = mysql_query("SELECT count(id_to) from conceptos where concepto_to like '%MASTOGRAFIA%' and id_to = '$row[6]' ", $horizonte) or die (mysql_error());
	$rowMa = mysql_fetch_row($resultMa); 
	
	if($rowMa[0]==0){$row[16]='0';} //echo $row[16];
	
	mysql_select_db($database_horizonte, $horizonte);
	$result1 = mysql_query("SELECT p.fNac_p, p.sexo_p, concat(p.nombre_p, ' ', p.apaterno_p), p.amaterno_p, date_format(p.fNac_p,'%d/%c/%Y'), s.cat_sexo from pacientes p left join catalogo_sexos s on s.id_sexo = p.sexo_p where p.id_p = $row[4] ", $horizonte) or die (mysql_error());
 	$row1 = mysql_fetch_row($result1);
	
	mysql_select_db($database_horizonte, $horizonte);
	$result1x = mysql_query("SELECT concepto_to, formato from conceptos where id_to = $row[6] ",$horizonte) or die (mysql_error());
 	$row1x = mysql_fetch_row($result1x);
	
	mysql_select_db($database_horizonte, $horizonte);
	$result2 = mysql_query("SELECT nombre_u, apaterno_u, amaterno_u, titulo_u, idSucursal_u, cedulaProfesional_u, id_u, sexo_u, firma_u, temporal_u from usuarios where id_u = $row[5] ", $horizonte) or die (mysql_error());
 	$row2 = mysql_fetch_row($result2);
	
	if($row2[0]=='A' and $row2[1] == 'QUIEN'){ $miMedico =$row2[0]." ".$row2[1]." ".$row2[2];}
	else{$miMedico = "REFIRIÓ: ".$row2[3]." ".$row2[0]." ".$row2[1]." ".$row2[2];}
	
	mysql_select_db($database_horizonte, $horizonte);
	$resultSu1 = mysql_query("SELECT link_pacs_externo from configuracion order by id_cf desc limit 1 ", $horizonte) or die (mysql_error());
 	$rowSu1 = mysql_fetch_row($resultSu1);
	
	$linkP = $rowSu1[0];
	
	mysql_select_db($database_horizonte, $horizonte);
	$result3=mysql_query("SELECT concepto_to, id_area_to from conceptos where id_to = $claveE", $horizonte) or die (mysql_error());
 	$row3 = mysql_fetch_row($result3);
	$areaE = sqlValue($row3[1], "int");
	
	$idUi = sqlValue($row[11], "int"); 
	$result4 = mysql_query("SELECT nombre_u, apaterno_u, amaterno_u, cedulaProfesional_u, id_u, sexo_u, titulo_u, firma_u, temporal_u from usuarios where id_u = $idUi ", $horizonte) or die (mysql_error());
 	$row4 = mysql_fetch_row($result4); $tempU = sqlValue($row4[8], "text"); //echo $row4[7];
	$medicoAutoriza = $row4[6]." ".$row4[0]." ".$row4[1]." ".$row4[2]; $tempU = sqlValue($row4[8], "text");
	
	if($row4[7]==1){
		mysql_select_db($database_horizonte, $horizonte); 
		$resultDo = mysql_query("SELECT ext_do, id_do from documentos where nombre_do = $tempU and que_es_do = 'FIRMA' and tipo_quien_do = 3", $horizonte) or die (mysql_error());
		$rowDo = mysql_fetch_row($resultDo);
		$myFirma = '<img src="../../../usuarios/firmas/files/'.$rowDo[1].'.'.$rowDo[0].'" height="100" width="" style=" border-style:none;">';
	 }else{$myFirma = '';}
	
	if($row4[7]==1){
		mysql_select_db($database_horizonte, $horizonte); 
 		$resultDo = mysql_query("SELECT ext_do from documentos where nombre_do = $tempU and que_es_do = 'FIRMA' and tipo_quien_do = 3", $horizonte) or die (mysql_error());
 		$rowDo = mysql_fetch_row($resultDo);
 	}
	
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
	
	mysql_select_db($database_horizonte, $horizonte);
	$result7 = mysql_query("SELECT count(v.id_vc) from venta_conceptos v left join conceptos c on c.id_to = v.id_concepto_es where v.referencia_vc = $ref and c.id_tipo_concepto_to = 3", $horizonte) or die (mysql_error());
	$row7 = mysql_fetch_row($result7);
	
	mysql_select_db($database_horizonte, $horizonte);
	$result8 = mysql_query("SELECT min(v.contador_vc), max(v.contador_vc) from venta_conceptos v left join conceptos c on c.id_to = v.id_concepto_es where v.referencia_vc = $ref and c.id_tipo_concepto_to = 3", $horizonte) or die (mysql_error());
	$row8 = mysql_fetch_row($result8);
	
	if($row8[0]>1){
		$razon = $row8[1] - $row8[0];
		$nome = $row2[7] - $razon;
	}else{$nome = $row2[7];}
	
	$nombre = $row1[2].' '.$row1[3];
	$medicoEstudio = $row2[3]." ".$row2[0]." ".$row2[1]." ".$row2[2];
	$medicoInterpreta = $row4[6]." ".$row4[0]." ".$row4[1]." ".$row4[2];
	
	$referenciaPacs = $row[20];
	
	$idPP = sqlValue($referenciaPacs, "text");
	
	//Seleccionamos el id del paciente en la tabla patient de la DB del ipacs
	mysql_select_db($database_ipacs, $ipacs);
  
	$resultP1 = mysql_query("SELECT pk from patient where pat_id = $idPP ", $ipacs) or die (mysql_error());
 	$rowP1 = mysql_fetch_row($resultP1); $idPP1 = sqlValue($rowP1[0], "int");//Is id de patient $idPP
	
	//Seleccionamos el número de imágenes en el estudio completo de la DB del ipacs
	mysql_select_db($database_ipacs, $ipacs);
  
	$resultNI = mysql_query("SELECT num_instances from study where patient_fk = $idPP1 ", $ipacs) or die (mysql_error());
 	$rowNI = mysql_fetch_row($resultNI); $ni = sqlValue($rowNI[0], "int");
	
	$i = 0; $j=0;
	$lista = '';
	
	//Seleccionamos el study_iuid de la tabla de study del ipacs para pasarlo al osirix
	mysql_select_db($database_ipacs, $ipacs);
	$consulta = "SELECT i.sop_iuid as mi, s.series_iuid as ms, e.study_iuid as me from instance i left join series s on s.pk = i.series_fk left join study e on e.pk = s.study_fk left join patient p on p.pk = e.patient_fk where p.pk = $idPP1";
	$query = mysql_query($consulta) or die (mysql_error());
	
	$c = 0;
	while ($fila = mysql_fetch_array($query)) { $c++;
		$lista = '"'.'osirix://?methodName=DownloadURL&amp;Display=YES&amp;URL='."'".'http://'.$host.':8080/wado?requestType=WADO&studyUID='.$fila['me'].'&seriesUID='.$fila['ms'].'&objectUID='.$fila['mi'].'&contentType=application%2Fdicom&transferSyntax=1.2.840.10008.1.2.1'."'".'"';
	};
	
	$tabla = '<div style=" width:100%; text-align:center; border:1px none red;" align="center"> <table id="p_contenido1" width="15cm" border="0" cellspacing="4" cellpadding="0"> <tr> <td width="360">PACIENTE: '.$row1[2].' '.$row1[3].'</td> <td nowrap>EDAD: '.$row1[0].' SEXO: '.$row1[1].' </td> </tr> <tr> <td class="myMedicoP">'.$miMedico.'</td> <td nowrap>FECHA '.$row[3].'</td> </tr> <tr> <td align="left" style="font-weight:bold;" nowrap>'.$row3[0].'</td> <td nowrap> REFERENCIA: '.$row[0].' </td> </tr> </table></div>';
	
	$tabla2 = '<table id="p_contenido2" width="100%" border="0" cellspacing="3" cellpadding="0"><tr><td colspan="2" height="40" valign="top">&nbsp;</td></tr> <tr> <td width="400" height="100" valign="top"></td> <td id="firmaDR" align="center" height="110"> '.$myFirma.' </td> </tr> <tr> <td>&nbsp;</td> <td nowrap align="center">'.$medicoAutoriza.'</td> </tr> <tr> <td nowrap></td> <td nowrap align="center"><span class="puestoDR"></span> CEDULA PROFESIONAL '.$row4[3].'</td> </tr> </table>';
	
	if($rowMNE[0] > 0 and $rowMNP[0] > 0){
		$xME='../../../sucursales/membretes/files/'.$rowMNE[1].'.'.$rowMNE[2];
		$xMP='../../../sucursales/membretes/files/'.$rowMNP[1].'.'.$rowMNP[2];
	} else{ $xME=''; $xMP=''; }
			
	$tabla = sqlValue($tabla, "text"); $tabla2 = sqlValue($tabla2, "text");
	$encaR = sqlValue($xME, "text"); $pieR = sqlValue($xMP, "text");
	mysql_select_db($database_horizonte, $horizonte);
	$sqlX = "UPDATE usuarios SET variable_temporal1_u = $tabla, variable_temporal2_u = $tabla2, variable_temporal3_u = $encaR, variable_temporal4_u = $pieR where id_u = $idU limit 1";
	$updateX = mysql_query($sqlX, $horizonte) or die (mysql_error());
 	
	if(!$updateX){ echo $sqlX; }
 	else{
		echo $nombre.';*}-{'.$row[0].';*}-{'.$row1[0].';*}-{'.$row1[1].";*}-{".$row[3].";*}-{".$row[1].";*}-{".$row[2].";*}-{".$medicoEstudio.";*}-{".$row3[0].";*}-{".$medicoInterpreta.";*}-{".$row4[3].";*}-{".$row[7].".png".";*}-{".$referenciaPacs.";*}-{".$row[10].";*}-{".$row1[4].";*}-{".$row4[5].";*}-{".$ni.";*}-{".$lista.";*}-{".$row4[6].";*}-{".$linkP.";*}-{".$row1x[0].';*}-{'.$row[16].';*}-{'.$rowMa[0].';*}-{'.$row4[7].';*}-{'.$row4[8].';*}-{'.$rowDo[0].';*}-{'.$rowMNE[0].';*}-{'.$rowMNE[1].';*}-{'.$rowMNE[2].';*}-{'.$rowMNP[0].';*}-{'.$rowMNP[1].';*}-{'.$rowMNP[2].';*}-{'.$row[15].';*}-{'.$row[21];
	}
	
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
 mysql_close($ipacs);
?>