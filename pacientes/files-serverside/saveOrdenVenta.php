<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");
	
//Generales
 $noTemp = sqlValue($_POST["noTemp"], "text");
 $sucursal = sqlValue($_POST["sucursal"], "int");
 $idPaciente = sqlValue($_POST["idPaciente"], "int");
 $idUsuario = sqlValue($_POST["idUsuario"], "int");
//Consulta
 $subtotalC = sqlValue($_POST["subtotalC"], "double");
 $totalC = sqlValue($_POST["totalC"], "double");
 $motivoC = sqlValue($_POST["motivoC"], "text");
 $adicionalesC = sqlValue($_POST["cargoAC"], "double");
 $medicoC = sqlValue($_POST["medicoC"], "int");
//Estudios Imagen
 $subtotalI = sqlValue($_POST["subtotalI"], "double");
 $totalI = sqlValue($_POST["totalI"], "double");
 $observacionesI = sqlValue($_POST["observacionesI"], "text");
 $adicionalesI = sqlValue($_POST["cargoAI"], "double");
 $medicoI = sqlValue($_POST["medicoI"], "int");
//Estudios Laboratorio
 $subtotalL = sqlValue($_POST["subtotalL"], "double");
 $totalL = sqlValue($_POST["totalL"], "double");
 $observacionesL = sqlValue($_POST["observacionesL"], "text");
 $adicionalesL = sqlValue($_POST["cargoAL"], "double");
 $medicoL = sqlValue($_POST["medicoL"], "int");
//Estudios Endoscopía
 $subtotalE = 0;
 $totalE = 0;
 $observacionesE = 'null';
 $adicionalesE = 0;
 $medicoE = 0;
//Servicios
 $subtotalS = sqlValue($_POST["subtotalS"], "double");
 $totalS = sqlValue($_POST["totalS"], "double");
 $observacionesS = sqlValue($_POST["observacionesS"], "text");
 $adicionalesS = sqlValue($_POST["cargoAS"], "double");
 $medicoS = sqlValue($_POST["medicoS"], "int");
//TOTALES
 $subtotal = sqlValue($_POST["subtotal"], "double");
 $iva = sqlValue($_POST["iva"], "double");
 $totalPagar = sqlValue($_POST["totalPagar"], "double");
 $suPago = sqlValue($_POST["suPago"], "double"); if($suPago == NULL){$suPago = 0;}
 $formaPago = sqlValue($_POST["formaPago"], "int");
//otros
 $facturada = sqlValue($_POST["facturada"], "int");
 $noCheque = sqlValue($_POST["noCheque"], "text");
 $descuentoT = sqlValue($_POST["descuentoT"], "double");
 $procedencia = sqlValue($_POST["procedencia"], "int");
 
 if($_POST["p_desc_cta"]==''){$p_desc_cta = 0;}else{$p_desc_cta = sqlValue($_POST["p_desc_cta"], "int");}
 if($_POST["desc_d_cta"]==''){$desc_d_cta = 0;}else{$desc_d_cta = sqlValue($_POST["desc_d_cta"], "double");}
 if($_POST["t_desc_cta"]==''){$t_desc_cta = 0;}else{$t_desc_cta = sqlValue($_POST["t_desc_cta"], "double");}
 
 if($_POST["p_desc_img"]==''){$p_desc_img = 0;}else{$p_desc_img = sqlValue($_POST["p_desc_img"], "int");}
 if($_POST["desc_d_img"]==''){$desc_d_img = 0;}else{$desc_d_img = sqlValue($_POST["desc_d_img"], "double");}
 if($_POST["t_desc_img"]==''){$t_desc_img = 0;}else{$t_desc_img = sqlValue($_POST["t_desc_img"], "double");}
 
 if($_POST["p_desc_lab"]==''){$p_desc_lab = 0;}else{$p_desc_lab = sqlValue($_POST["p_desc_lab"], "int");}
 if($_POST["desc_d_lab"]==''){$desc_d_lab = 0;}else{$desc_d_lab = sqlValue($_POST["desc_d_lab"], "double");}
 if($_POST["t_desc_lab"]==''){$t_desc_lab = 0;}else{$t_desc_lab = sqlValue($_POST["t_desc_lab"], "double");}
 
 if($_POST["p_desc_ser"]==''){$p_desc_ser = 0;}else{$p_desc_ser = sqlValue($_POST["p_desc_ser"], "int");}
 if($_POST["desc_d_ser"]==''){$desc_d_ser = 0;}else{$desc_d_ser = sqlValue($_POST["desc_d_ser"], "double");}
 if($_POST["t_desc_ser"]==''){$t_desc_ser = 0;}else{$t_desc_ser = sqlValue($_POST["t_desc_ser"], "double");}
 
 if($_POST["p_desc_gra"]==''){$p_desc_gra = 0;}else{$p_desc_gra = sqlValue($_POST["p_desc_gra"], "int");}
 if($_POST["desc_d_gra"]==''){$desc_d_gra = 0;}else{$desc_d_gra = sqlValue($_POST["desc_d_gra"], "double");}
 if($_POST["t_desc_gra"]==''){$t_desc_gra = 0;}else{$t_desc_gra = sqlValue($_POST["t_desc_gra"], "double");}
 
 if($_POST["suPago"]<$_POST["totalPagar"]){ $estatus_pago = 0; $saldo=$_POST["totalPagar"]-$_POST["suPago"]; }
 else{$estatus_pago = 1; $saldo=0; }
 
 $ingresoT=$totalPagar;
 
 if($_POST["agendar"]==1){ 
 	$now = sqlValue($_POST["fechaC"], "text"); $now1 = sqlValue($_POST["fechaC1"], "text");
	$fecha1="'".$_POST["fechaC1"]." 00:00:00"."'"; $fecha2="'".$_POST["fechaC1"]." 23:59:59"."'";
	$da=str_replace("-", "", $_POST["fechaC1"]);
 } 
 else{ 
 	$now = sqlValue(date('Y-m-d H:i:s'), "date"); $fecha1="'".date('Y-m-d')." 00:00:00"."'";
 	$fecha2="'".date('Y-m-d')." 23:59:59"."'"; $da=date('Ymd');
 }
 $contador = 0;
 
 mysql_select_db($database_horizonte, $horizonte);
 $resultR = mysql_query("SELECT count(id_ov) from orden_venta where fecha_venta_ov between ".$fecha1." and ".$fecha2." ", $horizonte) or die(mysql_error());
 $rowR = mysql_fetch_row($resultR);
 
 $noRef=0;

 if ($rowR[0]==0){ $noRef=$da."-"."1"; $noRef="'".$noRef."'"; $contador = 1;}
 else{ $daa=$rowR[0]+1; $noRef=$da."-".$daa; $noRef="'".$noRef."'"; $contador = $daa;}
 
 mysql_select_db($database_horizonte, $horizonte);
 $resultRsq = mysql_query("SELECT count(id_ov) from orden_venta where referencia_ov = ".$noRef." ", $horizonte) or die(mysql_error());
 $rowRsq = mysql_fetch_row($resultRsq);
 
 if($rowRsq[0]>0){
	 mysql_select_db($database_horizonte, $horizonte);
 	$resultRG = mysql_query("SELECT max(contador_ov), referencia_ov from orden_venta where fecha_venta_ov between ".$fecha1." and ".$fecha2." limit 1 ", $horizonte) or die(mysql_error());
 	$rowRG = mysql_fetch_row($resultRG); //echo sqlValue($rowRG[0], "int");
 
	 $porciones = explode("-", sqlValue($rowRG[1], "text"));
	 $a = $rowRG[0]+1;
	 $contador = $a;
	 $noRef = $porciones[0]."-".$a;
	 $noRef=$noRef."'";
 }

 mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO orden_venta (no_temp_ov, sucursal_ov, id_paciente_ov, usuario_ov, total_c, motivo_c_ov, total_ei, observaciones_i_ov, total_el, observaciones_l_ov, total_s, observaciones_s_ov, adicionales_ei_ov, adicionales_el_ov, adicionales_s_ov, gran_total_ov, abonado_ov, saldo_ov, fecha_venta_ov, referencia_ov, total_ee, adicionales_c_ov, adicionales_ee_ov, observaciones_e_ov, sub_total_c, sub_total_i, sub_total_l, sub_total_e, sub_total_s, medico_c_ov, medico_ei_ov, medico_el_ov, medico_ee_ov, personal_s_ov, estado_pago_ov, facturada_ov, forma_pago_ov, no_cheque_ov, subtotal_ov,iva_ov,descuento_total_ov,p_desc_cta,desc_d_cta,t_desc_cta,p_desc_img,desc_d_img,t_desc_img,p_desc_lab,desc_d_lab,t_desc_lab,p_desc_serv,desc_d_serv,t_desc_serv,p_desc_gral,desc_d_gral,t_desc_gral,contador_ov,procedencia_ov) ";
$sql.= "VALUES ($noTemp, $sucursal, $idPaciente, $idUsuario, $totalC, $motivoC, $totalI, $observacionesI, $totalL, $observacionesL, $totalS, $observacionesS, $adicionalesI, $adicionalesL, $adicionalesS, $totalPagar, $suPago, $saldo, $now, ".$noRef.", $totalE, $adicionalesC, $adicionalesE, $observacionesE, $subtotalC, $subtotalI, $subtotalL, $subtotalE, $subtotalS, $medicoC, $medicoI, $medicoL, $medicoE, $medicoS, $estatus_pago, $facturada, $formaPago, $noCheque,$subtotal,$iva,$descuentoT,$p_desc_cta,$desc_d_cta,$t_desc_cta,$p_desc_img,$desc_d_img,$t_desc_img,$p_desc_lab,$desc_d_lab,$t_desc_lab,$p_desc_ser,$desc_d_ser,$t_desc_ser,$p_desc_gra,$desc_d_gra,$t_desc_gra,$contador,$procedencia)";
$insertar = mysql_query($sql, $horizonte) or die(mysql_error()); 

mysql_select_db($database_horizonte, $horizonte);
$resultRH=mysql_query("SELECT count(id_hc) from historia_clinica where id_paciente_hc=$idPaciente",$horizonte) or die(mysql_error());
$rowRH = mysql_fetch_row($resultRH);
if($rowRH[0]==0){ 
	mysql_select_db($database_horizonte, $horizonte); 
	$sqlH="INSERT INTO historia_clinica(id_paciente_hc,id_usuario_hc,fecha_registro_hc) VALUES ($idPaciente, $idUsuario, $now)"; 
	$insertH = mysql_query($sqlH, $horizonte) or die (mysql_error()); 
}
	
if (!$insertar){ echo $sql;}
else {
	//GUARDAMOS UN CONCEPTO EN VENTA_CONCEPTOS PARA CADA CARGO ADICIONAL, CON SU RESPECTIVO DEPARTAMENTO. y uno para el IVA en CONTA
	mysql_select_db($database_horizonte, $horizonte);
 	$sqlV = "INSERT INTO venta_conceptos (id_personal_medico_vc, precio_normal_vc,id_convenio_vc,total_vc,id_paciente_vc,id_usuario_vc,fecha_venta_vc,departamento_vc,area_vc,id_concepto_es,id_sucursal_vc,tipo_concepto_vc,no_temp_vc,id_conceptos_beneficios) ";
	$sqlV.= "VALUES 
	(0,$adicionalesC,1,$adicionalesC,$idPaciente,$idUsuario,$now,4,83,19,$sucursal,6,$noTemp,0), 
	(0,$adicionalesI,1,$adicionalesI,$idPaciente,$idUsuario,$now,2,80,20,$sucursal,6,$noTemp,0), 
	(0,$adicionalesL,1,$adicionalesL,$idPaciente,$idUsuario,$now,1,81,21,$sucursal,6,$noTemp,0), 
	(0,$adicionalesS,1,$adicionalesS,$idPaciente,$idUsuario,$now,4,83,19,$sucursal,6,$noTemp,0), 
	(0,$iva,1,$iva,$idPaciente,$idUsuario,$now,8,8,24,$sucursal,7,$noTemp,0)";
	$insertarV = mysql_query($sqlV, $horizonte) or die(mysql_error());
	//FIN GUARDAMOS UN CONCEPTO EN VENTA_CONCEPTOS Y UN PAGO EN PAGOS PARA CADA CARGO ADICIONAL, CON SU RESPECTIVO DEPARTAMENTO
	
	mysql_select_db($database_horizonte, $horizonte);
 	$resultR4 =mysql_query("SELECT referencia_ov from orden_venta order by id_ov desc limit 1 ", $horizonte) or die(mysql_error());
 	$rowR4 = mysql_fetch_row($resultR4);
	
	mysql_select_db($database_horizonte, $horizonte);
	$sqlCx = "update venta_conceptos set motivo_visita_vc = $motivoC where tipo_concepto_vc = 1 and no_temp_vc = $noTemp";
	$insertarCx = mysql_query($sqlCx, $horizonte) or die(mysql_error());
 
	mysql_select_db($database_horizonte, $horizonte);
	$consulta = "SELECT id_vc, id_conceptos_beneficios from venta_conceptos where no_temp_vc = $noTemp";
	$query = mysql_query($consulta) or die (mysql_error());
	
	$c = 0;
	while ($fila = mysql_fetch_array($query)) { $c++;
		$id = $fila['id_vc'];  $idCB = $fila['id_conceptos_beneficios'];
		$refi = "-".$c; 
		$referencia = sqlValue($rowR4[0], "text").sqlValue($refi, "text");
		$referencia = sqlValue(str_replace("'","",$referencia), "text");$referenciaOV = sqlValue($rowR4[0], "text");
		$sql = "UPDATE venta_conceptos SET temporal_vc = 0, referencia_vc = $referenciaOV, contador_vc = $c where id_vc = $id ";
		//Ahora actualizamos la fecha de usado del concepto del beneficio dle paciente
		$sqlCB = "UPDATE conceptos_beneficios SET usado_cb = 1, fecha_usado_cb = $now where id_cb = $idCB limit 1";
 
 		mysql_select_db($database_horizonte, $horizonte);
 		$insertar = mysql_query($sql, $horizonte) or die (mysql_error());
		
		mysql_select_db($database_horizonte, $horizonte);
 		$insertarCB = mysql_query($sqlCB, $horizonte) or die (mysql_error());
	};
	
	//Vamos a guardar los pagos de cada uno de los conceptos de la tabla de venta de conceptos, un pago por cada concepto ok.
	//Empezamos por FARMACIA
	mysql_select_db($database_horizonte, $horizonte);
	$consultaF="SELECT id_vc, id_convenio_vc, precio_normal_vc,  departamento_vc, area_vc, id_sucursal_vc, tipo_concepto_vc, id_personal_medico_vc, id_paciente_vc, no_temp_vc, referencia_vc from venta_conceptos where no_temp_vc like '".$_POST['noTemp']."' and departamento_vc = 3";
	$queryF = mysql_query($consultaF) or die (mysql_error());
	$miPago = $_POST["suPago"]; //echo 'mi pago inicial es '.$miPago.'.';
	
	while ($filaF = mysql_fetch_array($queryF)){ 
		$idF = $filaF['id_vc'];
		$idConvenio = $filaF['id_convenio_vc'];
		$precioConcepto = $filaF['precio_normal_vc'];
		$idDepartamentoC = $filaF['departamento_vc'];
		$idAreaC = $filaF['area_vc'];
		$idSucursalC = $filaF['id_sucursal_vc'];
		$idTipoC = $filaF['tipo_concepto_vc'];
		$idPersonalMedicoC = $filaF['id_personal_medico_vc'];
		$idPacienteC = $filaF['id_paciente_vc'];
		$noTemporalC = $filaF['no_temp_vc'];
		$referenciaC = $filaF['referencia_vc'];
		if($miPago<=$precioConcepto){
			$totalPago = $miPago;
			$miPago = 0;
			$miSaldoC = $precioConcepto - $totalPago;
		}else{
			$totalPago = $precioConcepto;
			$miPago = $miPago - $precioConcepto;
			$miSaldoC = $precioConcepto - $totalPago;
		}
		
		$sqlF = "INSERT INTO pagos_ov(id_vc_pag,id_convenio_pag,total_vc_pag,saldo_vc_pag,pago_pag,id_departamento_pag,id_area_pag,usuario_pag,fecha_pag,referencia_pag,sucursal_pag,tipo_concepto_pag,id_personal_medico_pag,id_paciente_pag,no_temp_pag) VALUES ($idF, $idConvenio, $precioConcepto, $miSaldoC, $totalPago, $idDepartamentoC, $idAreaC, $idUsuario, $now, ".$noRef.", $idSucursalC, $idTipoC, $idPersonalMedicoC, $idPacienteC, $noTemp) ";
 
 		mysql_select_db($database_horizonte, $horizonte);
 		$insertarF = mysql_query($sqlF, $horizonte) or die (mysql_error());
		if (!$insertarF){ echo $sqlF;} else {} 
		
	};//fin de Farmacia
	
	//Hospital
	mysql_select_db($database_horizonte, $horizonte);
	$consultaH="SELECT id_vc, id_convenio_vc, precio_normal_vc,  departamento_vc, area_vc, id_sucursal_vc, tipo_concepto_vc, id_personal_medico_vc, id_paciente_vc, no_temp_vc, referencia_vc from venta_conceptos where no_temp_vc like '".$_POST['noTemp']."' and departamento_vc = 5";
	$queryH = mysql_query($consultaH) or die (mysql_error()); //$miPago = $_POST["suPago"];
	
	while ($filaH = mysql_fetch_array($queryH)){
		$idF = $filaH['id_vc'];
		$idConvenio = $filaH['id_convenio_vc'];
		$precioConcepto = $filaH['precio_normal_vc'];
		$idDepartamentoC = $filaH['departamento_vc'];
		$idAreaC = $filaH['area_vc'];
		$idSucursalC = $filaH['id_sucursal_vc'];
		$idTipoC = $filaF['tipo_concepto_vc'];
		$idPersonalMedicoC = $filaH['id_personal_medico_vc'];
		$idPacienteC = $filaH['id_paciente_vc'];
		$noTemporalC = $filaH['no_temp_vc'];
		$referenciaC = $filaH['referencia_vc'];
		if($miPago<=$precioConcepto){
			$totalPago = $miPago; $miPago = 0;
			$miSaldoC = $precioConcepto - $totalPago;
		}else{
			$totalPago = $precioConcepto;
			$miPago = $miPago - $precioConcepto;
			$miSaldoC = $precioConcepto - $totalPago;
		}
		
		$sqlH = "INSERT INTO pagos_ov(id_vc_pag,id_convenio_pag,total_vc_pag,saldo_vc_pag,pago_pag,id_departamento_pag,id_area_pag,usuario_pag,fecha_pag,referencia_pag,sucursal_pag,tipo_concepto_pag,id_personal_medico_pag,id_paciente_pag,no_temp_pag) VALUES ($idF, $idConvenio, $precioConcepto, $miSaldoC, $totalPago, $idDepartamentoC, $idAreaC, $idUsuario, $now, ".$noRef.", $idSucursalC, $idTipoC, $idPersonalMedicoC, $idPacienteC, $noTemp) ";
 
		mysql_select_db($database_horizonte, $horizonte);
		$insertarH = mysql_query($sqlH, $horizonte) or die (mysql_error());
		if (!$insertarH){ echo $sqlH;} else {} 

	};//Fin de Hospital
	
	//Seguimos con el departamento de Laboratorio
	mysql_select_db($database_horizonte, $horizonte);
	$consultaL="SELECT id_vc, id_convenio_vc, precio_normal_vc,  departamento_vc, area_vc, id_sucursal_vc, tipo_concepto_vc, id_personal_medico_vc, id_paciente_vc, no_temp_vc, referencia_vc from venta_conceptos where no_temp_vc like '".$_POST['noTemp']."' and departamento_vc = 1";
	$queryL = mysql_query($consultaL) or die (mysql_error()); //$miPago = $_POST["suPago"];
	
	while ($filaL = mysql_fetch_array($queryL)){
		$idF = $filaL['id_vc'];
		$idConvenio = $filaL['id_convenio_vc'];
		$precioConcepto = $filaL['precio_normal_vc'];
		$idDepartamentoC = $filaL['departamento_vc'];
		$idAreaC = $filaL['area_vc'];
		$idSucursalC = $filaL['id_sucursal_vc'];
		$idTipoC = $filaL['tipo_concepto_vc'];
		$idPersonalMedicoC = $filaL['id_personal_medico_vc'];
		$idPacienteC = $filaL['id_paciente_vc'];
		$noTemporalC = $filaL['no_temp_vc'];
		$referenciaC = $filaL['referencia_vc'];
		if($miPago<=$precioConcepto){
			$totalPago = $miPago; $miPago = 0;
			$miSaldoC = $precioConcepto - $totalPago;
		}else{
			$totalPago = $precioConcepto;
			$miPago = $miPago - $precioConcepto;
			$miSaldoC = $precioConcepto - $totalPago;
		}
		
		$sqlL = "INSERT INTO pagos_ov(id_vc_pag,id_convenio_pag,total_vc_pag,saldo_vc_pag,pago_pag,id_departamento_pag,id_area_pag,usuario_pag,fecha_pag,referencia_pag,sucursal_pag,tipo_concepto_pag,id_personal_medico_pag,id_paciente_pag,no_temp_pag) VALUES ($idF, $idConvenio, $precioConcepto, $miSaldoC, $totalPago, $idDepartamentoC, $idAreaC, $idUsuario, $now, ".$noRef.", $idSucursalC, $idTipoC, $idPersonalMedicoC, $idPacienteC, $noTemp) ";
 
		mysql_select_db($database_horizonte, $horizonte);
		$insertarL = mysql_query($sqlL, $horizonte) or die (mysql_error());
		if (!$insertarL){ echo $sqlL;} else {} 

	};//Fin de Laboratorio
	
	//Seguimos con el departamento de Imagen
	mysql_select_db($database_horizonte, $horizonte);
	$consultaI="SELECT id_vc, id_convenio_vc, precio_normal_vc,  departamento_vc, area_vc, id_sucursal_vc, tipo_concepto_vc, id_personal_medico_vc, id_paciente_vc, no_temp_vc, referencia_vc from venta_conceptos where no_temp_vc like '".$_POST['noTemp']."' and departamento_vc = 2";
	$queryI = mysql_query($consultaI) or die (mysql_error()); //$miPago = $_POST["suPago"];
	
	while ($filaI = mysql_fetch_array($queryI)){
		$idF = $filaI['id_vc'];
		$idConvenio = $filaI['id_convenio_vc'];
		$precioConcepto = $filaI['precio_normal_vc'];
		$idDepartamentoC = $filaI['departamento_vc'];
		$idAreaC = $filaI['area_vc'];
		$idSucursalC = $filaI['id_sucursal_vc'];
		$idTipoC = $filaI['tipo_concepto_vc'];
		$idPersonalMedicoC = $filaI['id_personal_medico_vc'];
		$idPacienteC = $filaI['id_paciente_vc'];
		$noTemporalC = $filaI['no_temp_vc'];
		$referenciaC = $filaI['referencia_vc'];
		
		if($miPago<=$precioConcepto){
			$totalPago = $miPago; $miPago = 0;
			$miSaldoC = $precioConcepto - $totalPago; //echo 'mi pago '.$miPago.' es menor igual a '.$precioConcepto;
		}else{//echo 'mi pago '.$miPago.' es mayor a '.$precioConcepto;
			$totalPago = $precioConcepto;
			$miPago = $miPago - $precioConcepto;
			$miSaldoC = $precioConcepto - $totalPago;
		}
		
		$sqlI = "INSERT INTO pagos_ov(id_vc_pag,id_convenio_pag,total_vc_pag,saldo_vc_pag,pago_pag,id_departamento_pag,id_area_pag,usuario_pag,fecha_pag,referencia_pag,sucursal_pag,tipo_concepto_pag,id_personal_medico_pag,id_paciente_pag,no_temp_pag) VALUES ($idF, $idConvenio, $precioConcepto, $miSaldoC, $totalPago, $idDepartamentoC, $idAreaC, $idUsuario, $now, ".$noRef.", $idSucursalC, $idTipoC, $idPersonalMedicoC, $idPacienteC, $noTemp) ";
 
		mysql_select_db($database_horizonte, $horizonte);
		$insertarI = mysql_query($sqlI, $horizonte) or die (mysql_error());
		if (!$insertarI){ echo $sqlI;} else {} 

	};//Fin de Imagen
	
	//Seguimos con el departamento de Servicios
	mysql_select_db($database_horizonte, $horizonte);
	$consultaE="SELECT es_beneficio_vc, id_concepto_es, id_vc from venta_conceptos where no_temp_vc like '".$_POST['noTemp']."' and departamento_vc = 15";
	$queryE = mysql_query($consultaE); 
	
	while ($filaE = mysql_fetch_array($queryE)){
		if($filaE['es_beneficio_vc']==1){ $idCto = sqlValue($filaE['id_concepto_es'], "int");
			
			mysql_select_db($database_horizonte, $horizonte); 
			$resultCG=mysql_query("SELECT id_beneficio_to from conceptos where id_to = $idCto ",$horizonte) or die (mysql_error());
			$rowESG = mysql_fetch_row($resultCG);
	 
			$idConceptoB = sqlValue($rowESG[0], "int");
	
			mysql_select_db($database_horizonte, $horizonte);
			$consultaE3=mysql_query("SELECT id_beneficio_to from conceptos where id_to = $idCto ");
			$rowES3 = mysql_fetch_row($consultaE3); $idConvenioB = sqlValue($rowES3[0], "int");
			
			//asignamos el convenio al paciente
			list($dia, $mes, $ano ) = explode( "/", sqlValue(date('Y-m-d H:i:s'), "date") ); $raya = "-";
			
			$fI = sqlValue(date('Y-m-d'), "date");
			$miAno = date('Y'); $miDia = date('d'); 
			$miAno = $miAno + 1;$miMes = date('m');
			$fF = $miAno.'-'.$miMes.'-'.$miDia;
			$fF = sqlValue($fF, "date"); //echo $fF;
					
			$idU = sqlValue($_POST["idUsuario"], "int");
			$idP = sqlValue($_POST["idPaciente"], "int");
			$idC = $idConvenioB;
			$now = sqlValue(date('Y-m-d H:i:s'), "date");
			 
			mysql_select_db($database_horizonte, $horizonte);
			$sql = "INSERT INTO convenios_paciente (id_paciente_cvp, id_convenio_cvp, fecha_expedicion_cvp, fecha_expiracion_cvp, usuario_cvp, fecha_cvp)";
			$sql.= "VALUES ($idP, $idC, $fI, $fF, $idU, now() )";
			  
			$update = mysql_query($sql, $horizonte) or die (mysql_error());
				
			if (!$update) { echo $sql;}
			else{
				mysql_select_db($database_horizonte, $horizonte);
				$resultX=mysql_query("SELECT MAX(id_cvp) from convenios_paciente limit 1 ", $horizonte) or die (mysql_error());
				$rowX = mysql_fetch_row($resultX); $idConvenio_paciente = sqlValue($rowX[0], "int");
				
				mysql_select_db($database_horizonte, $horizonte);
				$result = mysql_query("SELECT id_ac, infinito_ac, cantidad_ac from asigna_conceptos_convenios where id_convenio_ac = $idC", $horizonte) or die (mysql_error()); 
				
				while ( $row = mysql_fetch_row($result) ){ 	
					if($row[1]==''){$miInfinito = 0;}else{$miInfinito = $row[1];}
					$miInfinito = sqlValue($miInfinito, "int");
					
					if($miInfinito==1){$i=1;}else{$i=$row[2];}
					
					mysql_select_db($database_horizonte, $horizonte);
					$sqlZ = "INSERT INTO conceptos_beneficios (id_concepto_convenio_cb, id_convenio_paciente_cb, infinito_cb, id_paciente_cb, id_usuario_cb, fecha_cb)";
					$sqlZ.= "VALUES ($row[0], $idConvenio_paciente, $miInfinito, $idP, $idU, $now )";
					
					for($j=1;$j<=$i;$j++){ $updateZ = mysql_query($sqlZ, $horizonte) or die (mysql_error()); }
						
				} 
			}
		//Fin asignamos convenio al paciente
		}else{
		
		}
	};//Fin de Servicios */
	
	//Seguimos con el departamento de Translados
	mysql_select_db($database_horizonte, $horizonte);
	$consultaT="SELECT id_vc, id_convenio_vc, precio_normal_vc,  departamento_vc, area_vc, id_sucursal_vc, tipo_concepto_vc, id_personal_medico_vc, id_paciente_vc, no_temp_vc, referencia_vc from venta_conceptos where no_temp_vc like '".$_POST['noTemp']."' and departamento_vc = 6";
	$queryT = mysql_query($consultaT) or die (mysql_error()); //$miPago = $_POST["suPago"];
	
	while ($filaT = mysql_fetch_array($queryT)){
		$idF = $filaT['id_vc'];
		$idConvenio = $filaT['id_convenio_vc'];
		$precioConcepto = $filaT['precio_normal_vc'];
		$idDepartamentoC = $filaT['departamento_vc'];
		$idAreaC = $filaT['area_vc'];
		$idSucursalC = $filaT['id_sucursal_vc'];
		$idTipoC = $filaT['tipo_concepto_vc'];
		$idPersonalMedicoC = $filaT['id_personal_medico_vc'];
		$idPacienteC = $filaT['id_paciente_vc'];
		$noTemporalC = $filaT['no_temp_vc'];
		$referenciaC = $filaT['referencia_vc'];
		if($miPago<=$precioConcepto){
			$totalPago = $miPago; $miPago = 0;
			$miSaldoC = $precioConcepto - $totalPago;
		}else{
			$totalPago = $precioConcepto;
			$miPago = $miPago - $precioConcepto;
			$miSaldoC = $precioConcepto - $totalPago;
		}
		
		$sqlT = "INSERT INTO pagos_ov(id_vc_pag,id_convenio_pag,total_vc_pag,saldo_vc_pag,pago_pag,id_departamento_pag,id_area_pag,usuario_pag,fecha_pag,referencia_pag,sucursal_pag,tipo_concepto_pag,id_personal_medico_pag,id_paciente_pag,no_temp_pag) VALUES ($idF, $idConvenio, $precioConcepto, $miSaldoC, $totalPago, $idDepartamentoC, $idAreaC, $idUsuario, $now, ".$noRef.", $idSucursalC, $idTipoC, $idPersonalMedicoC, $idPacienteC, $noTemp) ";
 
		mysql_select_db($database_horizonte, $horizonte);
		$insertarT = mysql_query($sqlT, $horizonte) or die (mysql_error());
		if (!$insertarT){ echo $sqlT;} else {} 

	};//Fin de Translados
	
	//Seguimos con el departamento de Honorarios Médicos
	mysql_select_db($database_horizonte, $horizonte);
	$consultaM="SELECT id_vc, id_convenio_vc, precio_normal_vc,  departamento_vc, area_vc, id_sucursal_vc, tipo_concepto_vc, id_personal_medico_vc, id_paciente_vc, no_temp_vc, referencia_vc from venta_conceptos where no_temp_vc like '".$_POST['noTemp']."' and departamento_vc = 4";
	$queryM = mysql_query($consultaM) or die (mysql_error());
	
	while ($filaM = mysql_fetch_array($queryM)){
		$idF = $filaM['id_vc'];
		$idConvenio = $filaM['id_convenio_vc'];
		$precioConcepto = $filaM['precio_normal_vc'];
		$idDepartamentoC = $filaM['departamento_vc'];
		$idAreaC = $filaM['area_vc'];
		$idSucursalC = $filaM['id_sucursal_vc'];
		$idTipoC = $filaM['tipo_concepto_vc'];
		$idPersonalMedicoC = $filaM['id_personal_medico_vc'];
		$idPacienteC = $filaM['id_paciente_vc'];
		$noTemporalC = $filaM['no_temp_vc'];
		$referenciaC = $filaM['referencia_vc'];
		if($miPago<=$precioConcepto){
			$totalPago = $miPago; $miPago = 0;
			$miSaldoC = $precioConcepto - $totalPago;
		}else{
			$totalPago = $precioConcepto;
			$miPago = $miPago - $precioConcepto;
			$miSaldoC = $precioConcepto - $totalPago;
		}
		
		$sqlM = "INSERT INTO pagos_ov(id_vc_pag,id_convenio_pag,total_vc_pag,saldo_vc_pag,pago_pag,id_departamento_pag,id_area_pag,usuario_pag,fecha_pag,referencia_pag,sucursal_pag,tipo_concepto_pag,id_personal_medico_pag,id_paciente_pag,no_temp_pag) VALUES ($idF, $idConvenio, $precioConcepto, $miSaldoC, $totalPago, $idDepartamentoC, $idAreaC, $idUsuario, $now, ".$noRef.", $idSucursalC, $idTipoC, $idPersonalMedicoC, $idPacienteC, $noTemp) ";
 
		mysql_select_db($database_horizonte, $horizonte);
		$insertarM = mysql_query($sqlM, $horizonte) or die (mysql_error());
		if (!$insertarM){ echo $sqlM;} else {} 

	};//Fin de Honorarios Médicos
	
	//Seguimos con los demás departamentos
	mysql_select_db($database_horizonte, $horizonte);
	$consultaO="SELECT id_vc, id_convenio_vc, precio_normal_vc,  departamento_vc, area_vc, id_sucursal_vc, tipo_concepto_vc, id_personal_medico_vc, id_paciente_vc, no_temp_vc, referencia_vc from venta_conceptos where no_temp_vc like '".$_POST['noTemp']."' and departamento_vc NOT IN (3,4,5,1,2,6,4,15)";//,15 (3,4,5,1,2,6,4)
	$queryO = mysql_query($consultaO) or die (mysql_error());
	
	while ($filaO = mysql_fetch_array($queryO)){
		$idF = $filaO['id_vc'];
		$idConvenio = $filaO['id_convenio_vc'];
		$precioConcepto = $filaO['precio_normal_vc'];
		$idDepartamentoC = $filaO['departamento_vc'];
		$idAreaC = $filaO['area_vc'];
		$idSucursalC = $filaO['id_sucursal_vc'];
		$idTipoC = $filaO['tipo_concepto_vc'];
		$idPersonalMedicoC = $filaO['id_personal_medico_vc'];
		$idPacienteC = $filaO['id_paciente_vc'];
		$noTemporalC = $filaO['no_temp_vc'];
		$referenciaC = $filaO['referencia_vc'];
		if($miPago<=$precioConcepto){
			$totalPago = $miPago; $miPago = 0;
			$miSaldoC = $precioConcepto - $totalPago;
		}else{
			$totalPago = $precioConcepto;
			$miPago = $miPago - $precioConcepto;
			$miSaldoC = $precioConcepto - $totalPago;
		}
		
		$sqlO = "INSERT INTO pagos_ov(id_vc_pag,id_convenio_pag,total_vc_pag,saldo_vc_pag,pago_pag,id_departamento_pag,id_area_pag,usuario_pag,fecha_pag,referencia_pag,sucursal_pag,tipo_concepto_pag,id_personal_medico_pag,id_paciente_pag,no_temp_pag) VALUES ($idF, $idConvenio, $precioConcepto, $miSaldoC, $totalPago, $idDepartamentoC, $idAreaC, $idUsuario, $now, ".$noRef.", $idSucursalC, $idTipoC, $idPersonalMedicoC, $idPacienteC, $noTemp) ";
 
		mysql_select_db($database_horizonte, $horizonte);
		$insertarO = mysql_query($sqlO, $horizonte) or die (mysql_error());
		if (!$insertarO){ echo $sqlO;} else {} 
	};//Fin de los demás departamentos
	
	//para el correo de facturación
	mysql_select_db($database_horizonte, $horizonte); 
 	$resultDF = mysql_query("
	
		SELECT p.nombre_p, p.apaterno_p, p.amaterno_p, p.rfc_f_p, p.razon_social_p, p.calle_pf, p.noExt_pf, p.noInt_pf, p.digitos_banco_p, p.email_p, mEs.d_estado, mMun.d_municipio, mCol.d_asenta, mCol.d_codigo, b.nombrecito_b, fp.forma_pago_fp from orden_venta ov left join pacientes p on p.id_p = ov.id_paciente_ov left join mexico mEs on mEs.id_mx = p.entidadFederativa_pf left join mexico mMun on mMun.id_mx = p.municipio_pf left join mexico mCol on mCol.id_mx = p.colonia_pf left join catalogo_bancos b on b.id_b = p.id_banco_p left join catalogo_forma_pago fp on fp.id_fp = ov.forma_pago_ov where ov.referencia_ov = ".$noRef." 
		
		", $horizonte) or die (mysql_error());
 	$rowDF = mysql_fetch_row($resultDF);
	
	echo 1;
}
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>