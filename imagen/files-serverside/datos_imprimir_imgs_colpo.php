<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$id_s = sqlValue($_POST["id_s"], "int");

mysql_select_db($database_horizonte, $horizonte);
$query_usuario1 = sprintf("SELECT interpretacion_vc FROM venta_conceptos WHERE id_vc = %s", $_POST["idVC"]);
$usuario1 = mysql_query($query_usuario1, $horizonte) or die(mysql_error());
$row_usuario1 = mysql_fetch_assoc($usuario1);
$totalRows_usuario1 = mysql_num_rows($usuario1);

	mysql_select_db($database_horizonte, $horizonte);
	$result = mysql_query("SELECT v.referencia_vc, v.interpretacion_vc, v.nota_interpretacion, date_format(v.fecha_venta_vc,'%d/%c/%Y'), v.id_paciente_vc, v.id_personal_medico_vc, v.id_concepto_es, v.usuarioEdo5_e, v.contador_vc, e.id_area_to, v.nota_radiologo_vc, v.usuarioEdo5_e, DATE_FORMAT(v.fecha_venta_vc,'%Y%m%d'), v.usuarioEdo5_e, v.observaciones_vc, v.id_anesteciologo_vc, o.sucursal_ov, DATE_FORMAT(v.fecha_venta_vc,'%Y%n%d'), o.sucursal_ov, v.birad_vc, s.nombre_su, s.id_su, concat(s.id_su,'.',s.id_su) from venta_conceptos v left join conceptos e on e.id_to = v.id_concepto_es left join orden_venta o on o.referencia_ov = v.referencia_vc left join sucursales s on s.id_su = o.sucursal_ov where v.id_vc = $_POST[idVC] ", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result); 
	
	$refOV = sqlValue($row[0], "text"); $idAnes = sqlValue($row[15], "int");
	
	$claveE = sqlValue($row[6], "int"); $ref = sqlValue($row[0], "text");
 	$idUautoriza = sqlValue($row[7], "int"); $idUmedico = sqlValue($row[5], "int");
	
	mysql_select_db($database_horizonte, $horizonte);
	$result1 = mysql_query("SELECT p.fNac_p, p.sexo_p, concat(p.nombre_p, ' ', p.apaterno_p), p.amaterno_p, date_format(p.fNac_p,'%d/%c/%Y'), s.cat_sexo from pacientes p left join catalogo_sexos s on s.id_sexo = p.sexo_p where p.id_p = $row[4] ", $horizonte) or die (mysql_error());
 	$row1 = mysql_fetch_row($result1);
	
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
	
	$result3=mysql_query("SELECT concepto_to, id_area_to from conceptos where id_to = $row[6] ",$horizonte) or die (mysql_error());
 	$row3 = mysql_fetch_row($result3);
	
	$result2 = mysql_query("SELECT nombre_u, apaterno_u, amaterno_u, titulo_u, idSucursal_u, cedulaProfesional_u, id_u, sexo_u, firma_u, temporal_u from usuarios where id_u = $row[5] ", $horizonte) or die (mysql_error());
 	$row2 = mysql_fetch_row($result2);
	
	if($row2[0]=='A' and $row2[1] == 'QUIEN'){ $miMedico =$row2[0]." ".$row2[1]." ".$row2[2];}
	else{$miMedico = "REFIRIÓ: ".$row2[3]." ".$row2[0]." ".$row2[1]." ".$row2[2];}

$tabla0 = '<table id="p_contenido4" width="100%" border="0" cellspacing="3" cellpadding="0" style="width:100%;"> <tr> <td class="encaH" width="50%" style="font-size:9pt;">PACIENTE: '.$row1[2].' '.$row1[3].'</td> <td class="encaH" nowrap style="font-size:9pt;">EDAD: '.$row1[0].' SEXO: '.$row1[5].' </td>  </tr> <tr> <td class="myMedicoP" style="font-size:9pt;">'.$miMedico.'</td> <td nowrap style="font-size:9pt;">FECHA '.$row[3].'</td>  </tr> <tr> <td align="left" style="font-weight:bold; font-size:9pt;" nowrap>'.$row3[0].'</td> <td nowrap style="font-size:9pt;">REFERENCIA: '.$row[0].' </td> </tr> </table>';

$carpeta = $_POST["idVC"];
mysql_select_db($database_horizonte, $horizonte);
$queryG1 = mysql_query("SELECT count(id_ie) FROM img_ultrasonido where id_estudio_vc_ie = $carpeta and a_reporte_ie = 1 ", $horizonte) or die (mysql_error()); $rowG1 = mysql_fetch_row($queryG1);
switch($rowG1[0]){
	case 1:
		mysql_select_db($database_horizonte, $horizonte);
		$queryK = mysql_query("SELECT id_ie, nombre_ie, imagen_ie FROM img_ultrasonido where id_estudio_vc_ie = $carpeta and a_reporte_ie = 1 and tumb_ie = 1 and imagen_ie != 'NaN_1' order by id_ie desc limit 1; ", $horizonte) or die (mysql_error());
		$rowK = mysql_fetch_row($queryK);
		$img1 = explode('_1.png', $rowK[1]);
		$tableX='
		<table id="table2" width="100%" height="1100" border="0" cellspacing="0" cellpadding="2"><tr> 
		<td nowrap valign="middle" align="center">
		<img id="myImg1" width="742" style="border:1px solid black;" src="imagen/img_colpo/filemanager/source/'.$carpeta.'/'.$img1[0].'" />
		</td> 
		</tr> </table>
		';
		$orientation = 'portrait'; //landscape
	break;
	case 2:
		mysql_select_db($database_horizonte, $horizonte);
		$queryK = mysql_query("SELECT id_ie, nombre_ie, imagen_ie FROM img_ultrasonido where id_estudio_vc_ie = $carpeta and a_reporte_ie = 1 and tumb_ie = 1 and imagen_ie != 'NaN_1' order by id_ie desc limit 1; ", $horizonte) or die (mysql_error());
		$rowK = mysql_fetch_row($queryK);
		mysql_select_db($database_horizonte, $horizonte);
		$queryK2 = mysql_query("SELECT id_ie, nombre_ie, imagen_ie FROM img_ultrasonido where id_estudio_vc_ie = $carpeta and a_reporte_ie = 1 and tumb_ie = 1 and imagen_ie != 'NaN_1' and id_ie not in ($rowK[0]) order by id_ie desc limit 2; ", $horizonte) or die (mysql_error());
		$rowK2 = mysql_fetch_row($queryK2);
		$img1 = explode('_1.png', $rowK[1]); $img2 = explode('_1.png', $rowK2[1]);
		$tableX= '
		<table id="table2" width="100%" height="1100" border="0" cellspacing="1" cellpadding="2"> 
		<tr> 
		<td height="50%" valign="bottom" align="center">
			<img id="myImg2" width="520" style="border:1px solid black;" src="imagen/img_colpo/filemanager/source/'.$carpeta.'/'.$img1[0].'" />
		</td> 
		</tr>
		<tr> 
		<td height="50%" valign="top" align="center">
			<img id="myImg3" width="520" style="border:1px solid black;" src="imagen/img_colpo/filemanager/source/'.$carpeta.'/'.$img2[0].'" />
		</td> 
		</tr> 
		</table>
		';
	break;
	case 3:
		mysql_select_db($database_horizonte, $horizonte);
		$queryK = mysql_query("SELECT id_ie, nombre_ie, imagen_ie FROM img_ultrasonido where id_estudio_vc_ie = $carpeta and a_reporte_ie = 1 and tumb_ie = 1 and imagen_ie != 'NaN_1' order by id_ie desc limit 1; ", $horizonte) or die (mysql_error());
		$rowK = mysql_fetch_row($queryK);
		mysql_select_db($database_horizonte, $horizonte);
		$queryK2 = mysql_query("SELECT id_ie, nombre_ie, imagen_ie FROM img_ultrasonido where id_estudio_vc_ie = $carpeta and a_reporte_ie = 1 and tumb_ie = 1 and imagen_ie != 'NaN_1' and id_ie not in ($rowK[0]) order by id_ie desc limit 2; ", $horizonte) or die (mysql_error());
		$rowK2 = mysql_fetch_row($queryK2);
		mysql_select_db($database_horizonte, $horizonte);
		$queryK3 = mysql_query("SELECT id_ie, nombre_ie, imagen_ie FROM img_ultrasonido where id_estudio_vc_ie = $carpeta and a_reporte_ie = 1 and tumb_ie = 1 and imagen_ie != 'NaN_1' and id_ie not in ($rowK[0],$rowK2[0]) order by id_ie desc limit 3; ", $horizonte) or die (mysql_error());
		$rowK3 = mysql_fetch_row($queryK3);
		$img1 = explode('_1.png', $rowK[1]); $img2 = explode('_1.png', $rowK2[1]); $img3 = explode('_1.png', $rowK3[1]);
		$tableX= '
		<table id="table2" width="100%" height="1100" border="0" cellspacing="1" cellpadding="2">
		<tr> 
		<td align="center" valign="bottom" height="33.3%"><img id="myImg4" width="350" style="border:1px solid black;" src="imagen/img_colpo/filemanager/source/'.$carpeta.'/'.$img1[0].'" /></td> </tr>
		<tr> 
		<td align="center" height="3%"><img id="myImg5" width="350" style="border:1px solid black;" src="imagen/img_colpo/filemanager/source/'.$carpeta.'/'.$img2[0].'" /></td> </tr> 
		<tr> 
		<td align="center" valign="top" height="33.3%"><img id="myImg6" width="350" style="border:1px solid black;" src="imagen/img_colpo/filemanager/source/'.$carpeta.'/'.$img3[0].'" /></td> </tr> 
		</table>
		';
	break;
	case 4:
		mysql_select_db($database_horizonte, $horizonte);
		$queryK = mysql_query("SELECT id_ie, nombre_ie, imagen_ie FROM img_ultrasonido where id_estudio_vc_ie = $carpeta and a_reporte_ie = 1 and tumb_ie = 1 and imagen_ie != 'NaN_1' order by id_ie desc limit 1; ", $horizonte) or die (mysql_error());
		$rowK = mysql_fetch_row($queryK);
		mysql_select_db($database_horizonte, $horizonte);
		$queryK2 = mysql_query("SELECT id_ie, nombre_ie, imagen_ie FROM img_ultrasonido where id_estudio_vc_ie = $carpeta and a_reporte_ie = 1 and tumb_ie = 1 and imagen_ie != 'NaN_1' and id_ie not in ($rowK[0]) order by id_ie desc limit 2; ", $horizonte) or die (mysql_error());
		$rowK2 = mysql_fetch_row($queryK2);
		mysql_select_db($database_horizonte, $horizonte);
		$queryK3 = mysql_query("SELECT id_ie, nombre_ie, imagen_ie FROM img_ultrasonido where id_estudio_vc_ie = $carpeta and a_reporte_ie = 1 and tumb_ie = 1 and imagen_ie != 'NaN_1' and id_ie not in ($rowK[0],$rowK2[0]) order by id_ie desc limit 3; ", $horizonte) or die (mysql_error());
		$rowK3 = mysql_fetch_row($queryK3);
		mysql_select_db($database_horizonte, $horizonte);
		$queryK4 = mysql_query("SELECT id_ie, nombre_ie, imagen_ie FROM img_ultrasonido where id_estudio_vc_ie = $carpeta and a_reporte_ie = 1 and tumb_ie = 1 and imagen_ie != 'NaN_1' and id_ie not in ($rowK[0],$rowK2[0],$rowK3[0]) order by id_ie desc limit 3; ", $horizonte) or die (mysql_error());
		$rowK4 = mysql_fetch_row($queryK4);
		$img1 = explode('_1.png', $rowK[1]); $img2 = explode('_1.png', $rowK2[1]); $img3 = explode('_1.png', $rowK3[1]);
		$img4 = explode('_1.png', $rowK4[1]);
		$tableX= '
		<table id="table2" width="100%" height="1100" border="0" cellspacing="1" cellpadding="2">
		<tr> 
			<td width="50%" height="50%" align="center" valign="bottom"><img id="myImg7" width="370" style="border:1px solid black;" src="imagen/img_colpo/filemanager/source/'.$carpeta.'/'.$img1[0].'" /></td>
			<td height="" align="center" valign="bottom"><img id="myImg8" width="370" style="border:1px solid black;" src="imagen/img_colpo/filemanager/source/'.$carpeta.'/'.$img2[0].'" /></td> 
		</tr> 
		<tr> 
			<td height="" align="center" valign="top"><img id="myImg9" width="370" style="border:1px solid black;" src="imagen/img_colpo/filemanager/source/'.$carpeta.'/'.$img3[0].'" /></td>
			<td height="" align="center" valign="top"><img id="myImg10" width="370" style="border:1px solid black;" src="imagen/img_colpo/filemanager/source/'.$carpeta.'/'.$img4[0].'" /></td> 
		</tr> 
		</table>
		';
	break;
	case 5:
		mysql_select_db($database_horizonte, $horizonte);
		$queryK = mysql_query("SELECT id_ie, nombre_ie, imagen_ie FROM img_ultrasonido where id_estudio_vc_ie = $carpeta and a_reporte_ie = 1 and tumb_ie = 1 and imagen_ie != 'NaN_1' order by id_ie desc limit 1; ", $horizonte) or die (mysql_error());
		$rowK = mysql_fetch_row($queryK);
		mysql_select_db($database_horizonte, $horizonte);
		$queryK2 = mysql_query("SELECT id_ie, nombre_ie, imagen_ie FROM img_ultrasonido where id_estudio_vc_ie = $carpeta and a_reporte_ie = 1 and tumb_ie = 1 and imagen_ie != 'NaN_1' and id_ie not in ($rowK[0]) order by id_ie desc limit 2; ", $horizonte) or die (mysql_error());
		$rowK2 = mysql_fetch_row($queryK2);
		mysql_select_db($database_horizonte, $horizonte);
		$queryK3 = mysql_query("SELECT id_ie, nombre_ie, imagen_ie FROM img_ultrasonido where id_estudio_vc_ie = $carpeta and a_reporte_ie = 1 and tumb_ie = 1 and imagen_ie != 'NaN_1' and id_ie not in ($rowK[0],$rowK2[0]) order by id_ie desc limit 3; ", $horizonte) or die (mysql_error());
		$rowK3 = mysql_fetch_row($queryK3);
		mysql_select_db($database_horizonte, $horizonte);
		$queryK4 = mysql_query("SELECT id_ie, nombre_ie, imagen_ie FROM img_ultrasonido where id_estudio_vc_ie = $carpeta and a_reporte_ie = 1 and tumb_ie = 1 and imagen_ie != 'NaN_1' and id_ie not in ($rowK[0],$rowK2[0],$rowK3[0]) order by id_ie desc limit 3; ", $horizonte) or die (mysql_error());
		$rowK4 = mysql_fetch_row($queryK4);
		mysql_select_db($database_horizonte, $horizonte);
		$queryK5 = mysql_query("SELECT id_ie, nombre_ie, imagen_ie FROM img_ultrasonido where id_estudio_vc_ie = $carpeta and a_reporte_ie = 1 and tumb_ie = 1 and imagen_ie != 'NaN_1' and id_ie not in ($rowK[0],$rowK2[0],$rowK3[0],$rowK4[0]) order by id_ie desc limit 3; ", $horizonte) or die (mysql_error());
		$rowK5 = mysql_fetch_row($queryK5);
		$img1 = explode('_1.png', $rowK[1]); $img2 = explode('_1.png', $rowK2[1]); $img3 = explode('_1.png', $rowK3[1]);
		$img4 = explode('_1.png', $rowK4[1]); $img5 = explode('_1.png', $rowK5[1]);
		$tableX= '
		<table id="table2" width="100%" height="1100" border="0" cellspacing="1" cellpadding="2">
		<tr> 
			<td height="33.3%" align="right" valign="bottom"><img id="myImg11" width="340" style="border:1px solid black;" src="imagen/img_colpo/filemanager/source/'.$carpeta.'/'.$img1[0].'" /></td>
			<td height="33.3%" align="left" valign="bottom"><img id="myImg12" width="340" style="border:1px solid black;" src="imagen/img_colpo/filemanager/source/'.$carpeta.'/'.$img2[0].'" /></td> 
		</tr> 
		<tr> 
			<td height="1%" align="right" valign="middle"><img id="myImg13" width="340" style="border:1px solid black;" src="imagen/img_colpo/filemanager/source/'.$carpeta.'/'.$img3[0].'" /></td>
			<td height="1% align="left" valign="middle">
			<img id="myImg14" width="340" style="border:1px solid black;" src="imagen/img_colpo/filemanager/source/'.$carpeta.'/'.$img4[0].'" /></td> 
		</tr> 
		<tr> 
			<td height="33.3%" align="left" valign="top" colspan="2"><img id="myImg15" width="340" style="border:1px solid black;" src="imagen/img_colpo/filemanager/source/'.$carpeta.'/'.$img5[0].'" /></td>
		</tr> 
		</table>
		';
	break;
	case 6:
		mysql_select_db($database_horizonte, $horizonte);
		$queryK = mysql_query("SELECT id_ie, nombre_ie, imagen_ie FROM img_ultrasonido where id_estudio_vc_ie = $carpeta and a_reporte_ie = 1 and tumb_ie = 1 and imagen_ie != 'NaN_1' order by id_ie desc limit 1; ", $horizonte) or die (mysql_error());
		$rowK = mysql_fetch_row($queryK);
		mysql_select_db($database_horizonte, $horizonte);
		$queryK2 = mysql_query("SELECT id_ie, nombre_ie, imagen_ie FROM img_ultrasonido where id_estudio_vc_ie = $carpeta and a_reporte_ie = 1 and tumb_ie = 1 and imagen_ie != 'NaN_1' and id_ie not in ($rowK[0]) order by id_ie desc limit 2; ", $horizonte) or die (mysql_error());
		$rowK2 = mysql_fetch_row($queryK2);
		mysql_select_db($database_horizonte, $horizonte);
		$queryK3 = mysql_query("SELECT id_ie, nombre_ie, imagen_ie FROM img_ultrasonido where id_estudio_vc_ie = $carpeta and a_reporte_ie = 1 and tumb_ie = 1 and imagen_ie != 'NaN_1' and id_ie not in ($rowK[0],$rowK2[0]) order by id_ie desc limit 3; ", $horizonte) or die (mysql_error());
		$rowK3 = mysql_fetch_row($queryK3);
		mysql_select_db($database_horizonte, $horizonte);
		$queryK4 = mysql_query("SELECT id_ie, nombre_ie, imagen_ie FROM img_ultrasonido where id_estudio_vc_ie = $carpeta and a_reporte_ie = 1 and tumb_ie = 1 and imagen_ie != 'NaN_1' and id_ie not in ($rowK[0],$rowK2[0],$rowK3[0]) order by id_ie desc limit 3; ", $horizonte) or die (mysql_error());
		$rowK4 = mysql_fetch_row($queryK4);
		mysql_select_db($database_horizonte, $horizonte);
		$queryK5 = mysql_query("SELECT id_ie, nombre_ie, imagen_ie FROM img_ultrasonido where id_estudio_vc_ie = $carpeta and a_reporte_ie = 1 and tumb_ie = 1 and imagen_ie != 'NaN_1' and id_ie not in ($rowK[0],$rowK2[0],$rowK3[0],$rowK4[0]) order by id_ie desc limit 3; ", $horizonte) or die (mysql_error());
		$rowK5 = mysql_fetch_row($queryK5);
		mysql_select_db($database_horizonte, $horizonte);
		$queryK6 = mysql_query("SELECT id_ie, nombre_ie, imagen_ie FROM img_ultrasonido where id_estudio_vc_ie = $carpeta and a_reporte_ie = 1 and tumb_ie = 1 and imagen_ie != 'NaN_1' and id_ie not in ($rowK[0],$rowK2[0],$rowK3[0],$rowK4[0],$rowK5[0]) order by id_ie desc limit 3; ", $horizonte) or die (mysql_error());
		$rowK6 = mysql_fetch_row($queryK6);
		$img1 = explode('_1.png', $rowK[1]); $img2 = explode('_1.png', $rowK2[1]); $img3 = explode('_1.png', $rowK3[1]);
		$img4 = explode('_1.png', $rowK4[1]); $img5 = explode('_1.png', $rowK5[1]); $img6 = explode('_1.png', $rowK6[1]);
		$tableX= '
		<table id="table2" width="100%" height="1100" border="0" cellspacing="1" cellpadding="2">
		<tr> 
			<td height="33.3%" width="50%" align="right" valign="bottom"><img id="myImg16" width="340" style="border:1px solid black;" src="imagen/img_colpo/filemanager/source/'.$carpeta.'/'.$img1[0].'" /></td>
			<td height="33.3%" align="left" valign="bottom"><img id="myImg17" width="340" style="border:1px solid black;" src="imagen/img_colpo/filemanager/source/'.$carpeta.'/'.$img2[0].'" /></td> 
		</tr> 
		<tr> 
			<td height="1%" align="right" valign="middle"><img id="myImg18" width="340" style="border:1px solid black;" src="imagen/img_colpo/filemanager/source/'.$carpeta.'/'.$img3[0].'" /></td>
			<td height="" align="left" valign="middle"><img id="myImg19" width="340" style="border:1px solid black;" src="imagen/img_colpo/filemanager/source/'.$carpeta.'/'.$img4[0].'" /></td> 
		</tr> 
		<tr> 
			<td height="33.3%" align="right" valign="top"><img id="myImg20" width="340" style="border:1px solid black;" src="imagen/img_colpo/filemanager/source/'.$carpeta.'/'.$img5[0].'" /></td>
			<td height="33.3%" align="left" valign="top"><img id="myImg21" width="340" style="border:1px solid black;" src="imagen/img_colpo/filemanager/source/'.$carpeta.'/'.$img6[0].'" /></td>
		</tr> 
		</table>
		';
	break;
	default:
		$tableX= '';
};

	echo $tabla0.$tableX;
?>

<?php mysql_free_result($usuario);?>
<?php mysql_free_result($usuario1);?>
