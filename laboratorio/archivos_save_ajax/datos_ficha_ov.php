<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $ref = sqlValue($_POST["ref"],"text");
 
 mysql_select_db($database_horizonte, $horizonte);
 $resultIC = mysql_query("SELECT count(v.id_vc) from venta_conceptos v left join conceptos c on c.id_to = v.id_concepto_es where v.referencia_vc = $ref and c.id_tipo_concepto_to = 1 and v.temporal_vc = 0", $horizonte) or die (mysql_error());
 $rowIC = mysql_fetch_row($resultIC);
 
 mysql_select_db($database_horizonte, $horizonte);
 $resultII = mysql_query("SELECT count(v.id_vc) from venta_conceptos v left join conceptos c on c.id_to = v.id_concepto_es where v.referencia_vc = $ref and c.id_tipo_concepto_to = 4 and v.temporal_vc = 0", $horizonte) or die (mysql_error());
 $rowII = mysql_fetch_row($resultII);
 
 mysql_select_db($database_horizonte, $horizonte);
 $resultIL = mysql_query("SELECT count(v.id_vc) from venta_conceptos v left join conceptos c on c.id_to = v.id_concepto_es where v.referencia_vc = $ref and c.id_tipo_concepto_to = 3 and v.temporal_vc = 0", $horizonte) or die (mysql_error());
 $rowIL = mysql_fetch_row($resultIL);
 
 mysql_select_db($database_horizonte, $horizonte);
 $resultIS = mysql_query("SELECT count(v.id_vc) from venta_conceptos v left join conceptos c on c.id_to = v.id_concepto_es where v.referencia_vc = $ref and c.id_tipo_concepto_to = 2 and v.temporal_vc = 0", $horizonte) or die (mysql_error());
 $rowIS = mysql_fetch_row($resultIS);
 
 mysql_select_db($database_horizonte, $horizonte);
 $resultIF = mysql_query("SELECT count(v.id_vc) from venta_conceptos v left join conceptos c on c.id_to = v.id_concepto_es where v.referencia_vc = $ref and c.id_tipo_concepto_to = 5 and v.temporal_vc = 0", $horizonte) or die (mysql_error());
 $rowIF = mysql_fetch_row($resultIF);
 
 mysql_select_db($database_horizonte, $horizonte);
 $resultR = mysql_query("SELECT o.id_paciente_ov, DATE_FORMAT(o.fecha_venta_ov,'%d/%c/%Y %H:%i:%s'), u.usuario_u, o.subtotal_ov, adicionales_c_ov + adicionales_ei_ov + adicionales_el_ov + adicionales_s_ov + adicionales_p_ov, o.iva_ov, o.t_desc_cta + o.t_desc_img + o.t_desc_lab + o.t_desc_serv + o.t_desc_pro, o.gran_total_ov from orden_venta o left join usuarios u on u.id_u = o.usuario_ov where o.referencia_ov = $ref", $horizonte) or die (mysql_error());
 $rowR = mysql_fetch_row($resultR);
 
 mysql_select_db($database_horizonte, $horizonte);
 $resultA = mysql_query("SELECT sum(pago_pag) from pagos_ov where referencia_pag = $ref group by referencia_pag", $horizonte) or die (mysql_error());
 $rowA = mysql_fetch_row($resultA);
 
 $saldo = $rowR[7] - $rowA[0];
 
 if($saldo > 0){$estatus = 'CON SALDO';}else{ $saldo = 0; $estatus = 'PAGADA';}
 
 $idP = sqlValue($rowR[0],"int"); $idU = sqlValue($_POST["idU"],"int");
 
 mysql_select_db($database_horizonte, $horizonte);
 $result1 = mysql_query("SELECT p.nombre_completo_p, DATE_FORMAT(p.fNac_p,'%d/%c/%Y'), s.cat_sexo, p.fNac_p from pacientes p left join catalogo_sexos s on s.id_sexo = p.sexo_p where p.id_p = $idP ", $horizonte) or die (mysql_error());
 $row1 = mysql_fetch_row($result1);
 
 $fecha1 = new DateTime($row1[3]); $fecha2 = new DateTime(date("Y-m-d H:i:s")); $fecha = $fecha1->diff($fecha2);
 //printf('%d AÑOS %d MESES %d DÍAS %d HORAS %d MINUTOS', $fecha->y, $fecha->m, $fecha->d, $fecha->h, $fecha->i);
 $anos=$fecha->y; $meses=$fecha->m; $dias=$fecha->d; $horas=$fecha->h; $minutos=$fecha->i; $segundos=$fecha->s;
 if($anos>0){$row1[3]=$anos." AÑOS";}
 if($anos<1){
 	if($meses<=2 and $meses>=1){$row1[3]=$meses." MES(ES) ".$dias." DÍA(S)";}
 	if($meses>=3){$row1[3]=$meses." MES(ES) ";}
 	if($meses==0){$row1[3]=$dias." DÍA(S)";}
 	if($meses==0 and $dias<=1){$row1[3]=$dias." DÍA(S) ".$horas." HORA(S)";}
 	if($meses==0 and $dias<1){$row1[3]=$horas." HORA(S) ".$minutos." MINUTO(S)";}
 } 
 if($anos>150 or $anos<0){$row1[3]="DESCONOCIDA";}else{}
 
 mysql_select_db($database_horizonte, $horizonte);
 $result = mysql_query("
	SELECT vc.contador_vc, tc.tipo_concepto_tc, c.concepto_to, tc.tipo_concepto_tc, concat(vc.referencia_vc,'/',contador_vc), 
		vc.estatus_vc, vc.precio_vc,id_personal_medico_vc, e.estatus_est, vc.id_vc, c.id_departamento_to, vc.id_vc, vc.referencia_vc from venta_conceptos vc
		left join estatus e on e.id_est = vc.estatus_vc 
		left join conceptos c on c.id_to = vc.id_concepto_es 
		left join catalogo_tipo_conceptos tc on tc.id_tc = c.id_tipo_concepto_to 
		where vc.referencia_vc = $ref 
	", $horizonte) or die (mysql_error()); 
 $tableC = "<table class='table-condensed table-bordered' width='100%' height='100%'> \n"; 
 $tableC = $tableC."<tr class='bg-info'> <td>#</td> <td>CONCEPTO</td> <td>DESCRIPCI&Oacute;N</td> <td>ESTATUS</td> <td>PRECIO</td> </tr> \n";
 $cont = 0;
 while ( $row = mysql_fetch_row($result) ){ $cont++;
	$tableC = $tableC."<tr style='color:black;' class='$row[11]'>
			<td>$cont</td> <td>$row[1]</td> <td>$row[2]</td> <td>$row[8]</td> <td style='text-align:right'>$$row[6]</td>
		</tr> \n"; 
 } 
 $tableC = $tableC."</table> \n"; 
 
	 echo $row1[0].'*}'.$row1[3].' '.$row1[2].'*}'.$rowR[1].'*}'.$rowR[2].'*}'.$rowR[3].'*}'.$rowR[4].'*}'.$rowR[5].'*}'.$rowR[6].'*}'.$rowR[7].'*}'.$rowA[0].'*}'.$saldo.'*}'.$estatus.'*}'.$rowIC[0].'*}'.$rowII[0].'*}'.$rowIL[0].'*}'.$rowIS[0].'*}'.$rowIF[0].'*}'.$tableC;

//Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>