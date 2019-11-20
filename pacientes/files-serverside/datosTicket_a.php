<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $noTemp = sqlValue($_POST["noAleatorio"], "text"); $fecha = date('d/m/Y'); $hora = date('H:i:s');
 
 mysql_select_db($database_horizonte, $horizonte); 
 $resultR = mysql_query("SELECT o.referencia_ov, o.id_paciente_ov, o.adicionales_ei_ov, o.adicionales_el_ov, o.adicionales_s_ov, o.gran_total_ov, sum(p.pago_pag), p.pago_pag-o.gran_total_ov, o.usuario_ov, o.adicionales_c_ov, p.forma_pago_pag, p.no_cheque_pag, o.id_ov, o.adicionales_ei_ov, o.adicionales_el_ov, o.adicionales_s_ov, o.sucursal_ov, o.t_desc_cta + o.t_desc_img + o.t_desc_lab + o.t_desc_serv + o.t_desc_pro, su.no_temp_su, o.iva_ov, o.subtotal_ov, sum(p.pago_pag), o.gran_total_ov-sum(p.pago_pag), o.adicionales_p_ov from orden_venta o left join pagos_ov p on p.referencia_pag = o.referencia_ov left join sucursales su on su.id_su = o.sucursal_ov where o.referencia_ov = $noTemp order by p.id_pag desc", $horizonte) or die (mysql_error());
 $rowR = mysql_fetch_row($resultR); $idFormaPago = sqlValue($rowR[10], "int"); $idSucursal = sqlValue($rowR[16], "int");
 $tempSucursal = sqlValue($rowR[18], "text");
 
 mysql_select_db($database_horizonte, $horizonte); 
 $resultSu = mysql_query("SELECT estado_su, municipio_su, ciudad_su, colonia_su, calle_su, cp_su, telefono_su, email_su, id_su, id_su from sucursales where id_su = $idSucursal", $horizonte) or die (mysql_error());
 $rowSu = mysql_fetch_row($resultSu); $id_sucu_l = sqlValue($rowSu[9], "int");
 
 mysql_select_db($database_horizonte, $horizonte); 
 $resultCof = mysql_query("SELECT sitio_web from configuracion order by id_cf desc limit 1", $horizonte) or die (mysql_error());
 $rowCof = mysql_fetch_row($resultCof);
 
 mysql_select_db($database_horizonte, $horizonte); 
 $resultLo = mysql_query("SELECT count(id_do), id_do, ext_do from documentos where aleatorio_do = $tempSucursal and perfil_do = 1 and tipo_quien_do = 2 ", $horizonte) or die (mysql_error());
 $rowLo = mysql_fetch_row($resultLo);
 
 mysql_select_db($database_horizonte, $horizonte); 
 $resultFP = mysql_query("SELECT forma_pago_fp from catalogo_forma_pago where id_fp = $idFormaPago limit 1", $horizonte) or die (mysql_error());
 $rowFP = mysql_fetch_row($resultFP);
 
 mysql_select_db($database_horizonte, $horizonte); 
 $resultP = mysql_query("SELECT nombre_p, apaterno_p, amaterno_p, rfc_p, calle_p, id_p, entidadFederativa_p, municipio_p, colonia_p, cp_p from pacientes where id_p = $rowR[1] limit 1", $horizonte) or die (mysql_error());
 $rowP = mysql_fetch_row($resultP);
 $idEstadoP = sqlValue($rowP[6], "int"); $idMunicipioP = sqlValue($rowP[7], "int"); $idColoniaP = sqlValue($rowP[8], "int");
 
 mysql_select_db($database_horizonte, $horizonte); 
 $resultEP = mysql_query("SELECT d_estado from mexico where id_mx = $idEstadoP limit 1", $horizonte) or die (mysql_error());
 $rowEP = mysql_fetch_row($resultEP);
 
 mysql_select_db($database_horizonte, $horizonte); 
 $resultMP = mysql_query("SELECT d_municipio from mexico where id_mx = $idMunicipioP limit 1", $horizonte) or die (mysql_error());
 $rowMP = mysql_fetch_row($resultMP);
 
 mysql_select_db($database_horizonte, $horizonte); 
 $resultCP = mysql_query("SELECT d_asenta from mexico where id_mx = $idColoniaP limit 1", $horizonte) or die (mysql_error());
 $rowCP = mysql_fetch_row($resultCP);
 
 $direccionP = 'CALLE '.$rowP[4].' #'.$rowP[5].' COLONIA '.$rowCP[0].', '.$rowMP[0].', '.$rowEP[0];
 
 mysql_select_db($database_horizonte, $horizonte); 
 $resultU = mysql_query("SELECT nombre_u, apaterno_u, amaterno_u from usuarios where id_u = $rowR[8] limit 1", $horizonte) or die (mysql_error());
 $rowU = mysql_fetch_row($resultU);
 
 $paciente = $rowP[0]." ".$rowP[1]." ".$rowP[2]; $adicionales = $rowR[9]+$rowR[13]+$rowR[14]+$rowR[15]+$rowR[23];
		
echo $fecha.";}".$rowR[0].";}".$paciente.";}".$adicionales.";}".$rowR[5].";}".$rowR[6].";}".$rowR[7].";}".$rowU[0]." ".$rowU[1]." ".$rowU[2].";}".$fecha.";}".$hora.";}".$adicionales.";}".$rowFP[0].";}".$rowR[11].";}".$rowP[3].";}".$direccionP.";}".$rowSu[0].";}".$rowSu[1].";}".$rowSu[2].";}".$rowSu[3].";}".$rowSu[4].";}".$rowSu[5].";}".$rowSu[6].";}".$rowSu[7].";}".$rowCof[0].";}".$rowR[17].";}".$rowLo[0].";}".$rowLo[1].";}".$rowLo[2].";}".$rowR[19].";}".$rowR[20].";}".$rowR[21].";}".$rowR[22];

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>