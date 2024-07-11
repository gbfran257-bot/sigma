<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idP=sqlValue($_POST["idP"],"int"); $idU=sqlValue($_POST["idU"],"int"); $idE=sqlValue($_POST["idE"],"int"); //en VC
 
 mysql_select_db($database_horizonte, $horizonte);
 $result1 = mysql_query("SELECT p.nombre_completo_p, p.apaterno_p, p.amaterno_p, DATE_FORMAT(p.fNac_p,'%d/%c/%Y'), s.cat_sexo, p.fNac_p from pacientes p left join catalogo_sexos s on s.id_sexo = p.sexo_p where p.id_p = $idP ", $horizonte) or die (mysql_error());
 $row1 = mysql_fetch_row($result1);

 mysql_select_db($database_horizonte, $horizonte);
 $result2 = mysql_query("SELECT v.referencia_vc, v.id_concepto_es, v.nota_radiologo_vc, DATE_FORMAT(v.fecha_venta_vc,'%d/%c/%Y'), v.usuarioEdo4_e, v.id_personal_medico_vc, s.nombre_su, v.contador_vc, v.usuarioEdo4_e, s.id_su, concat(s.id_su,'.',s.id_su), c.id_tipo_concepto_to, s.no_temp_su, a.nombre_a, v.interpretacion_vc, s.clave_su from venta_conceptos v left join orden_venta o on o.referencia_ov = v.referencia_vc left join conceptos c on c.id_to = v.id_concepto_es left join sucursales s on s.id_su = o.sucursal_ov left join areas a on a.id_a = c.id_area_to where v.id_vc = $idE ", $horizonte) or die (mysql_error());
 $row2 = mysql_fetch_row($result2); $id_suc = sqlValue($row2[9], "int"); $ale_suc = sqlValue($row2[12], "text");
 
 	mysql_select_db($database_horizonte, $horizonte);
	$resultE=mysql_query("SELECT count(id_do), id_do, ext_do from documentos where aleatorio_do = $ale_suc and tipo_quien_do = 2 and nombre_do = 'ENCABEZADO' and que_es_do = 'MEMBRETE RESULTADOS LABORATORIO'",$horizonte) or die (mysql_error());
	$rowE = mysql_fetch_row($resultE);
		
	mysql_select_db($database_horizonte, $horizonte);
	$resultP=mysql_query("SELECT count(id_do), id_do, ext_do from documentos where aleatorio_do = $ale_suc and tipo_quien_do = 2 and nombre_do = 'PIE' and que_es_do = 'MEMBRETE RESULTADOS LABORATORIO'",$horizonte) or die (mysql_error());
	$rowP = mysql_fetch_row($resultP);
	
	if($rowE[0]>0 and $rowP[0]>0){$ep = 1;}else{$ep = 0;}
 
 $claveE = sqlValue($row2[1], "int");
 $ref = sqlValue($row2[0], "text");
 $idUautoriza = sqlValue($row2[4], "int");
 $idUmedico = sqlValue($row2[5], "int");

 $lista = ''; $k = 0; $lista1 = ''; $k1 = 0;
 mysql_select_db($database_horizonte, $horizonte);
 $consultaM = "SELECT m.metodo_me from asignar_metodo am left join conceptos b on b.aleatorio_c = am.aleatorio_ame left join metodos m on m.id_me = am.id_metodo_ame where b.id_to = $claveE group by am.id_metodo_ame ";
$query = mysql_query($consultaM) or die (mysql_error());
while ($fila = mysql_fetch_array($query)) {
	//$lista = $fila['metodo_me'];
	$lista = $lista.','.$fila['metodo_me'];
	/*if($k==0){ $lista = $fila['metodo_me']; }
	else if($k>2){ $lista = 'DIVERSOS'; }
	else{ $lista = $lista.','.$fila['metodo_me'];}*/
	$k++;
};if($k>2){ $lista = 'DIVERSOS'; }$lista=substr($lista,1);//echo $lista;

mysql_select_db($database_horizonte, $horizonte);
$consultaM1 ="SELECT m.muestra_mu from asignar_muestra am left join conceptos b on b.aleatorio_c = am.aleatorio_am left join muestras m on m.id_mu = am.id_muestra_am where b.id_to = $claveE group by am.id_muestra_am ";
$query1 = mysql_query($consultaM1) or die (mysql_error());
while ($fila1 = mysql_fetch_array($query1)) {
	//$lista1 = $fila1['muestra_mu'];
	$lista1 = $lista1.','.$fila1['muestra_mu'];
	/*if($k1==0){ $lista1 = $fila1['muestra_mu']; }
	else if($k1>2){ $lista1 = 'DIVERSAS'; }
	else{ $lista1 = $lista1.','.$fila1['muestra_mu'];}*/
	$k1++;
};if($k1>2){ $lista1 = 'DIVERSAS'; }$lista1=substr($lista1,1);//echo $lista;

mysql_select_db($database_horizonte, $horizonte);
$result4d = mysql_query("SELECT u.nombre_u, u.apaterno_u, u.amaterno_u, u.cedulaProfesional_u, u.id_u, u.sexo_u, t.abreviacion_ti, u.firma_u, u.temporal_u from usuarios u left join titulos t on t.id_ti = u.id_titulo_u where u.id_u = $idUautoriza ", $horizonte) or die (mysql_error());
$row4d = mysql_fetch_row($result4d);
$quimicoAutoriza = $row4d[0]." ".$row4d[1]." ".$row4d[2]; $tempU = sqlValue($row4d[8], "text");

$resultFt = mysql_query("SELECT count(id_do) from documentos where aleatorio_do = $tempU and firma_do = 1 ", $horizonte) or die (mysql_error());
$rowFt = mysql_fetch_row($resultFt);

if($rowFt[0]>0){
	mysql_select_db($database_horizonte, $horizonte); 
	$resultDo = mysql_query("SELECT ext_do, id_do from documentos where aleatorio_do = $tempU and firma_do = 1", $horizonte) or die (mysql_error());
	$rowDo = mysql_fetch_row($resultDo);
	$myFirma = '<img src="../../../usuarios/documentos/files/'.$rowDo[1].'.'.$rowDo[0].'" height="100" width="" style=" border-style:none;">';
 }else{$myFirma = '';}
 
 mysql_select_db($database_horizonte, $horizonte); //Membrete encabezado nota Evo
 $resultMNE = mysql_query("SELECT count(id_do), id_do, ext_do from documentos where aleatorio_do = $ale_suc and que_es_do = 'MEMBRETE RESULTADOS LABORATORIO' and tipo_quien_do = 2 and nombre_do = 'ENCABEZADO'", $horizonte) or die (mysql_error());
 $rowMNE = mysql_fetch_row($resultMNE);
 
 mysql_select_db($database_horizonte, $horizonte); //Membrete pie nota Evo
 $resultMNP = mysql_query("SELECT count(id_do), id_do, ext_do from documentos where aleatorio_do = $ale_suc and que_es_do = 'MEMBRETE RESULTADOS LABORATORIO' and tipo_quien_do = 2 and nombre_do = 'PIE'", $horizonte) or die (mysql_error());
 $rowMNP = mysql_fetch_row($resultMNP);

mysql_select_db($database_horizonte, $horizonte);
$result4d1 = mysql_query("SELECT u.nombre_u, u.apaterno_u, u.amaterno_u, u.cedulaProfesional_u, u.id_u, u.sexo_u, t.abreviacion_ti from usuarios u left join titulos t on t.id_ti = u.id_titulo_u where u.id_u = $idUmedico ", $horizonte) or die (mysql_error());
$row4d1 = mysql_fetch_row($result4d1);

if($row4d1[0]=='A' and $row4d1[1] == 'QUIEN'){ $miMedico =$row4d1[0]." ".$row4d1[1]." ".$row4d1[2];}
else{$miMedico = $row4d1[6]." ".$row4d1[0]." ".$row4d1[1]." ".$row4d1[2];}

mysql_select_db($database_horizonte, $horizonte);
$result3 = mysql_query("SELECT concepto_to, id_area_to from conceptos where id_to = $claveE ", $horizonte) or die (mysql_error());
$row3 = mysql_fetch_row($result3);
$areaE = sqlValue($row3[1], "int");

mysql_select_db($database_horizonte, $horizonte);
$result4 = mysql_query("SELECT nombre_a from areas where id_a = $areaE ", $horizonte) or die (mysql_error());
$row4 = mysql_fetch_row($result4);

mysql_select_db($database_horizonte, $horizonte);
$result5 = mysql_query("SELECT observaciones_l_ov from orden_venta where referencia_ov = $ref ", $horizonte) or die (mysql_error());
$row5 = mysql_fetch_row($result5);

mysql_select_db($database_horizonte, $horizonte);
$result6 = mysql_query("SELECT count(v.id_vc) from venta_conceptos v left join conceptos c on c.id_to = v.id_concepto_es where v.estatus_vc = 2 and v.referencia_vc = $ref and c.id_tipo_concepto_to = 3 order by v.id_vc desc", $horizonte) or die (mysql_error());
$row6 = mysql_fetch_row($result6);

$fecha1 = new DateTime($row1[5]); $fecha2 = new DateTime(date("Y-m-d H:i:s")); $fecha = $fecha1->diff($fecha2);
//printf('%d AÑOS %d MESES %d DÍAS %d HORAS %d MINUTOS', $fecha->y, $fecha->m, $fecha->d, $fecha->h, $fecha->i);
$anos=$fecha->y; $meses=$fecha->m; $dias=$fecha->d; $horas=$fecha->h; $minutos=$fecha->i; $segundos=$fecha->s;
if($anos>0){$row1[5]=$anos." AÑOS";}
if($anos<1){
	if($meses<=2 and $meses>=1){$row1[5]=$meses." MES(ES) ".$dias." DÍA(S)";}
	if($meses>=3){$row1[5]=$meses." MES(ES) ";}
	if($meses==0){$row1[5]=$dias." DÍA(S)";}
	if($meses==0 and $dias<=1){$row1[5]=$dias." DÍA(S) ".$horas." HORA(S)";}
	if($meses==0 and $dias<1){$row1[5]=$horas." HORA(S) ".$minutos." MINUTO(S)";}
} 
if($anos>150 or $anos<0){$row1[5]="DESCONOCIDA";}else{}

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

 $tabla = '
 	<div style=" width:100%; text-align:center; border:1px none red;" align="center">
		<table id="p_contenido1" width="15cm" border="0" cellspacing="4" cellpadding="0">
			<tr> 
				<td width="360">PACIENTE: '.$row1[0].'</td>
				<td nowrap>EDAD: '.$row1[5].' F. NAC: '.$row1[3].' SEXO: '.$row1[4].' </td>
			</tr>
			<tr>
				<td class="myMedicoP">'.$miMedico.'</td>
				<td nowrap>FECHA '.$row2[3].' SUCURSAL: '.$row2[15].'</td>
			</tr>
			<tr>
				<td align="left" style="font-weight:bold;">'.$row3[0].'</td>
				<td nowrap> REFERENCIA: '.$row2[0].' ESTUDIO: '.$nome.' DE '.$row7[0].' </td>
			</tr>
			<tr style="font-size:9px;" class="metod">
				<td>MUESTRA: '.$lista1.'</td>
				<td>MÉTODO: '.$lista.'</td>
			</tr>
		</table>
	</div>';

if($row2[2]!=''){$myOBS = '<em>OBSERVACIONES: </em> '.$row2[2].'';}else{$myOBS='&nbsp;';}
/*  $tabla2 = '<table id="p_contenido2" width="100%" border="1" cellspacing="3" cellpadding="0"><tr> <td width="300" height="100" valign="top"></td> <td id="firmaDR" align="center" height="110"> '.$myFirma.' </td> </tr> <tr> <td>&nbsp;</td> <td nowrap align="center"> AUTORIZADO POR '.$row4d[6].' '.$quimicoAutoriza.'</td> </tr> <tr> <td nowrap></td> <td nowrap align="center"><span class="puestoDR"></span> CEDULA PROFESIONAL '.$row4d[3].'</td> </tr> </table>'; */
$tabla2 = '<table id="p_contenido2" width="100%" border="0" cellspacing="3" cellpadding="0">
            <tr>
                <td width="400" height="90" valign="top"></td>
                <td id="firmaDR" align="center" height="90"> '.$myFirma.' </td>
            </tr>
            <tr>
                <td>AUTORIZADO POR:</td>
                <td nowrap align="center">'.$row4d[6].' '.$quimicoAutoriza.'</td>
            </tr>
            <tr>
                <td nowrap></td>
                <td nowrap align="center"><span class="puestoDR"></span> CEDULA PROFESIONAL '.$row4d[3].'</td>
            </tr>
          </table>';

 //obtenemos cuadro con firma de quien capturó el estudio
mysql_select_db($database_horizonte, $horizonte);
$queryDatosProceso = mysql_query("SELECT he.quien_proceso, u.nombre_u, u.apaterno_u, u.amaterno_u, u.cedulaProfesional_u, u.id_u, u.sexo_u, t.abreviacion_ti, u.firma_u, u.temporal_u FROM historial_estudios he LEFT JOIN usuarios u ON u.id_u = he.quien_proceso LEFT JOIN titulos t ON t.id_ti = u.id_titulo_u WHERE id_estudio = $idE ", $horizonte) or die (mysql_error());
$resultadoProceso = mysql_fetch_row($queryDatosProceso);

$temporalProceso = sqlValue($resultadoProceso[9], "text");

$buscarFirma = mysql_query("SELECT count(id_do) from documentos where aleatorio_do = ".$temporalProceso." and firma_do = 1 ", $horizonte) or die (mysql_error());
$resultadoFirma = mysql_fetch_row($buscarFirma);

if($resultadoFirma[0]>0){
	mysql_select_db($database_horizonte, $horizonte); 
	$buscarExtension = mysql_query("SELECT ext_do, id_do from documentos where aleatorio_do = ".$temporalProceso." and firma_do = 1", $horizonte) or die (mysql_error());
	$firmaCompleta = mysql_fetch_row($buscarExtension);
	$myFirma2 = '<img src="../../../usuarios/documentos/files/'.$firmaCompleta[1].'.'.$firmaCompleta[0].'" height="100" width="" style=" border-style:none;">';
 }else{
	$myFirma2 = '';
}

/*  $tabla5 = '<table id="p_contenido2" width="100%" border="0" cellspacing="3" cellpadding="0"><tr><td colspan="2" height="40" valign="top">'.$myOBS.'</td></tr> <tr> <td width="400" height="100" valign="top"></td> <td id="firmaDR2" align="center" height="110"> '.$myFirma2.' </td> </tr> <tr> <td>&nbsp;</td> <td nowrap align="center">'.$resultadoProceso[7].' '.$resultadoProceso[1] . ' ' . $resultadoProceso[2] . ' ' . $resultadoProceso[3].'</td> </tr> <tr> <td nowrap></td> <td nowrap align="center"><span class="puestoDR"></span> CEDULA PROFESIONAL '.$resultadoProceso[4].'</td> </tr> </table>'; */

$tabla5 = '<table id="p_contenido3" width="100%" border="0" cellspacing="3" cellpadding="0">
    <tr>
        <td colspan="2" height="30" valign="top">'.$myOBS.'</td>
    </tr>
    <tr>
		<td id="firmaDR2" align="center" height="90">'.$myFirma2.'</td>
		<td id="firmaDR2" align="center" height="90">'.$myFirma.'</td>
    </tr>
    <tr>
        <td nowrap align="center">PROCESADO Y CAPTURADO POR:</td>
        <td nowrap align="center">AUTORIZADO POR</td>
    </tr>
    <tr>
		<td nowrap align="center">'.$resultadoProceso[7].' '.$resultadoProceso[1].' '.$resultadoProceso[2].' '.$resultadoProceso[3].'</td>
		<td nowrap align="center">'.$row4d[6].' '.$quimicoAutoriza.'</td>
    </tr>
    <tr>
		<td nowrap align="center"><span class="puestoDR"></span> CEDULA PROFESIONAL '.$resultadoProceso[4].'</td>
		<td nowrap align="center"><span class="puestoDR"></span> CEDULA PROFESIONAL '.$row4d[3].'</td>
    </tr>
</table>';

 //
		
 $tabla = sqlValue($tabla, "text"); $tabla2 = sqlValue($tabla2, "text"); $tabla5 = sqlValue($tabla5, "text");
 mysql_select_db($database_horizonte, $horizonte);
 $sqlX = "UPDATE usuarios SET variable_temporal1_u = $tabla, variable_temporal2_u = $tabla2, variable_temporal5_u = $tabla5 where id_u = $idU limit 1";
 $updateX = mysql_query($sqlX, $horizonte) or die (mysql_error());
 
 mysql_select_db($database_horizonte, $horizonte);
 $resultC8 = mysql_query("SELECT id_concepto_es from venta_conceptos where id_vc = $idE ", $horizonte) or die (mysql_error());
 $rowC8 = mysql_fetch_row($resultC8); $idE8 = sqlValue($rowC8[0], "int");
 
 mysql_select_db($database_horizonte, $horizonte);
 $resultC = mysql_query("SELECT count(id_ab) from asignar_bases where id_estudio_ab = $idE8 ", $horizonte) or die (mysql_error());
 $rowC = mysql_fetch_row($resultC);
 
 if(!$updateX){ echo $sqlX; }
 else{
	 echo $row1[0].'. '.$row1[5].' '.$row1[4].'*}'.$row2[0].'*}'.$row3[0].'*}'.$row4[0].'*}'.$row5[0].'*}'.$row6[0].'*}'.$row4[0].'*}'.$areaE.'*}'.$row2[2].'*}'.$row1[3].'*}'.$row1[4].'*}'.$row1[5].'*}'.$row2[3].'*}'.$miMedico.'*}'.$quimicoAutoriza.'*}'.$row4d[3].'*}'.$lista1.'*}'.$lista.'*}'.$row4d[6].'*}'.$row2[6].'*}'.$nome.' DE '.$row7[0].'*}'.$row2[8].".png".'*}'.$row2[9].'*}'.$row2[10].'*}'.$row4d[7].'*}'.$row4d[8].'*}'.$rowDo[0].'*}'.$rowMNE[0].'*}'.$rowMNE[1].'*}'.$rowMNE[2].'*}'.$rowMNP[0].'*}'.$rowMNP[1].'*}'.$rowMNP[2].'*}'.$row2[11].'*}'.$ep.'*}'.$rowE[1].'*}'.$row2[13].'*}'.$rowC[0].'*}'.$row2[14].'*}'.$row2[15].$resultadoProceso[8].'*}'.$resultadoProceso[9].'*}'.$firmaCompleta[0];
 }

//Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>