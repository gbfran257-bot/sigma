<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");
 
 $id_paciente = sqlValue($_POST["id_paciente_ov"], "int");
 $idU = sqlValue($_POST["id_usr_reg"], "int");
 $id_sucu = sqlValue($_POST["sucursal_fi_p"], "int");
 $aleatorio = sqlValue($_POST["aleatorio_ov"], "text"); $id_medico_consulta = 1;
 $id_consulta = '';
 if(isset($_POST["beneficio_c1"])){$id_convenio_consulta = sqlValue($_POST["beneficio_c1"], "int");}else{$id_convenio_consulta = '';} 
 if(isset($_POST["medico_i"])){$id_medico_imagen = sqlValue($_POST["medico_i"], "int");}else{$id_medico_imagen = '';}
 if(isset($_POST["medico_l"])){$id_medico_laboratorio = sqlValue($_POST["medico_l"], "int");}else{$id_medico_laboratorio = '';}
 if(isset($_POST["medico_s"])){$id_medico_servicios = sqlValue($_POST["medico_s"], "int");}else{$id_medico_servicios = '';}
 $motivo_consulta = sqlValue(mb_strtoupper($_POST["motivo_c1"]), "text");
 $motivo_imagen = sqlValue(mb_strtoupper($_POST["motivo_i"]), "text");
 $motivo_laboratorio = sqlValue(mb_strtoupper($_POST["motivo_l"]), "text");
 $motivo_servicios = sqlValue(mb_strtoupper($_POST["motivo_s"]), "text");
 
 if($_POST["po_descuento_c1"]==''){$porcentaje_descuento_consulta = 0;}else{$porcentaje_descuento_consulta = sqlValue($_POST["po_descuento_c1"], "int");}
 if($_POST["da_descuento_c1"]==''){$descuento_directo_consulta = 0;}else{$descuento_directo_consulta = sqlValue($_POST["da_descuento_c1"], "double");}
 if($_POST["to_descuento_c1"]==''){$total_descuento_consulta = 0;}else{$total_descuento_consulta = sqlValue($_POST["to_descuento_c1"], "double");}
 if($_POST["cargo_extra_c1"]==''){$cargo_extra_consulta = 0;}else{$cargo_extra_consulta = sqlValue($_POST["cargo_extra_c1"], "double");}
 
 if($_POST["po_descuento_i"]==''){$porcentaje_descuento_imagen = 0;}else{$porcentaje_descuento_imagen = sqlValue($_POST["po_descuento_i"], "int");}
 if($_POST["da_descuento_i"]==''){$descuento_directo_imagen = 0;}else{$descuento_directo_imagen = sqlValue($_POST["da_descuento_i"], "double");}
 if($_POST["to_descuento_i"]==''){$total_descuento_imagen = 0;}else{$total_descuento_imagen = sqlValue($_POST["to_descuento_i"], "double");}
 if($_POST["cargo_extra_i"]==''){$cargo_extra_imagen = 0;}else{$cargo_extra_imagen = sqlValue($_POST["cargo_extra_i"], "double");}
 
 if($_POST["po_descuento_l"]==''){$porcentaje_descuento_laboratorio=0;}else{$porcentaje_descuento_laboratorio=sqlValue($_POST["po_descuento_l"], "int");}
 if($_POST["da_descuento_l"]==''){$descuento_directo_laboratorio=0;}else{$descuento_directo_laboratorio=sqlValue($_POST["da_descuento_l"], "double");}
 if($_POST["to_descuento_l"]==''){$total_descuento_laboratorio = 0;}else{$total_descuento_laboratorio = sqlValue($_POST["to_descuento_l"], "double");}
 if($_POST["cargo_extra_l"]==''){$cargo_extra_laboratorio = 0;}else{$cargo_extra_laboratorio = sqlValue($_POST["cargo_extra_l"], "double");}
 
 if($_POST["po_descuento_s"]==''){$porcentaje_descuento_servicios=0;}else{$porcentaje_descuento_servicios = sqlValue($_POST["po_descuento_s"], "int");}
 if($_POST["da_descuento_s"]==''){$descuento_directo_servicios = 0;}else{$descuento_directo_servicios = sqlValue($_POST["da_descuento_s"], "double");}
 if($_POST["to_descuento_s"]==''){$total_descuento_servicios = 0;}else{$total_descuento_servicios = sqlValue($_POST["to_descuento_s"], "double");}
 if($_POST["cargo_extra_s"]==''){$cargo_extra_servicios = 0;}else{$cargo_extra_servicios = sqlValue($_POST["cargo_extra_s"], "double");}
 
 if($_POST["po_descuento_p"]==''){$porcentaje_descuento_productos=0;}else{$porcentaje_descuento_productos = sqlValue($_POST["po_descuento_p"], "int");}
 if($_POST["da_descuento_p"]==''){$descuento_directo_productos = 0;}else{$descuento_directo_productos = sqlValue($_POST["da_descuento_p"], "double");}
 if($_POST["to_descuento_p"]==''){$total_descuento_productos = 0;}else{$total_descuento_productos = sqlValue($_POST["to_descuento_p"], "double");}
 if($_POST["cargo_extra_p"]==''){$cargo_extra_productos = 0;}else{$cargo_extra_productos = sqlValue($_POST["cargo_extra_p"], "double");}
 
 $motivo_extras_consulta = sqlValue(mb_strtoupper($_POST["motivo_descuento_c1"]), "text"); //No se guarda en ningún lado
 $motivo_extras_imagen = sqlValue(mb_strtoupper($_POST["motivo_descuento_i"]), "text"); //No se guarda en ningún lado
 $motivo_extras_lab = sqlValue(mb_strtoupper($_POST["motivo_descuento_l"]), "text"); //No se guarda en ningún lado
 $motivo_extras_servicios = sqlValue(mb_strtoupper($_POST["motivo_descuento_s"]), "text"); //No se guarda en ningún lado
 $motivo_extras_farmacia = sqlValue(mb_strtoupper($_POST["motivo_descuento_p"]), "text"); //No se guarda en ningún lado
 $precio_consulta = sqlValue($_POST["precio_c1"], "double");
 $precio_imagen = sqlValue($_POST["precio_i"], "double");
 $precio_laboratorio = sqlValue($_POST["precio_l"], "double");
 $precio_servicios = sqlValue($_POST["precio_s"], "double");
 $precio_productos = sqlValue($_POST["precio_p"], "double");
 
 $total_consulta = sqlValue($_POST["total_c1"], "double");
 $total_imagen = sqlValue($_POST["total_i"], "double");
 $total_laboratorio = sqlValue($_POST["total_l"], "double");
 $total_servicios = sqlValue($_POST["total_s"], "double");
 $total_productos = sqlValue($_POST["total_p"], "double");
 $subtotal = sqlValue($_POST["precio_c1"]+$_POST["precio_i"]+$_POST["precio_l"]+$_POST["precio_s"]+$_POST["precio_p"], "double");
 $iva_ov = sqlValue($_POST["iva_ov_h"], "double");
 $total_ov = sqlValue($_POST["total_ov_h"], "double");
 $forma_pago_ov = sqlValue($_POST["forma_pago_ov"], "int");
 $caja_ov = sqlValue($_POST["caja_ov"], "text");
 $facturada_ov = sqlValue($_POST["hay_iva_ov"], "int");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 
 $pago_ov_a = sqlValue($_POST["pago_ov_c"], "double");
 $pago_ov_i = sqlValue($_POST["pago_ov_i"], "double");
 $pago_ov_l = sqlValue($_POST["pago_ov_l"], "double");
 $pago_ov_f = sqlValue($_POST["pago_ov_f"], "double"); 
 
 $contador = 0; $noRef=0;
 
 $now = sqlValue(date('Y-m-d H:i:s'), "date"); $fecha1="'".date('Y-m-d')." 00:00:00"."'";
 $fecha2="'".date('Y-m-d')." 23:59:59"."'"; $da=date('Ymd');
 
 mysql_select_db($database_horizonte, $horizonte);
 $resultR = mysql_query("SELECT count(id_ov) from orden_venta where fecha_venta_ov between ".$fecha1." and ".$fecha2." ", $horizonte) or die(mysql_error());
 $rowR = mysql_fetch_row($resultR);

 if($rowR[0]==0){ $noRef=$da."-"."1"; $noRef="'".$noRef."'"; $contador = 1;} else{ $daa=$rowR[0]+1; $noRef=$da."-".$daa; $noRef="'".$noRef."'"; $contador = $daa;}
 
 mysql_select_db($database_horizonte, $horizonte);
 $resultRsq = mysql_query("SELECT count(id_ov) from orden_venta where referencia_ov = ".$noRef." ", $horizonte) or die(mysql_error());
 $rowRsq = mysql_fetch_row($resultRsq);
 
 if($rowRsq[0]>0){
	mysql_select_db($database_horizonte, $horizonte);
 	$resultRG = mysql_query("SELECT max(contador_ov), referencia_ov from orden_venta where fecha_venta_ov between ".$fecha1." and ".$fecha2." limit 1 ", $horizonte) or die(mysql_error());
 	$rowRG = mysql_fetch_row($resultRG); //echo sqlValue($rowRG[0], "int");
	$porciones = explode("-", sqlValue($rowRG[1], "text")); $a = $rowRG[0]+1; $contador = $a; $noRef = $porciones[0]."-".$a; $noRef=$noRef."'";
 }
  
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO orden_venta(total_c, subtotal_ov, gran_total_ov, sub_total_c, usuario_ov, id_paciente_ov, fecha_venta_ov, adicionales_c_ov, p_desc_cta, desc_d_cta, t_desc_cta, motivo_c_ov, medico_c_ov, referencia_ov, contador_ov, sucursal_ov, no_temp_ov, total_ei, total_el, total_s, sub_total_i, sub_total_l, sub_total_s, adicionales_ei_ov, adicionales_el_ov, adicionales_s_ov, medico_ei_ov, medico_el_ov, personal_s_ov, observaciones_i_ov, observaciones_l_ov, observaciones_s_ov, p_desc_img, desc_d_img, t_desc_img, p_desc_lab, desc_d_lab, t_desc_lab, p_desc_serv, desc_d_serv, t_desc_serv, iva_ov, total_p, sub_total_p, adicionales_p_ov, p_desc_pro, desc_d_pro, t_desc_pro, motivo_desc_c_ov, motivo_desc_i_ov, motivo_desc_l_ov, motivo_desc_s_ov, motivo_desc_f_ov) VALUES ($total_consulta, $subtotal, $total_ov, $precio_consulta, $idU, $id_paciente, $now, $cargo_extra_consulta, $porcentaje_descuento_consulta, $descuento_directo_consulta, $total_descuento_consulta, $motivo_consulta, $id_medico_consulta, ".$noRef.", $contador, $id_sucu, $aleatorio, $total_imagen, $total_laboratorio, $total_servicios, $precio_imagen, $precio_laboratorio, $precio_servicios, $cargo_extra_imagen, $cargo_extra_laboratorio, $cargo_extra_servicios, $id_medico_imagen, $id_medico_laboratorio, $id_medico_servicios, $motivo_imagen, $motivo_laboratorio, $motivo_servicios, $porcentaje_descuento_imagen, $descuento_directo_imagen, $total_descuento_imagen, $porcentaje_descuento_laboratorio, $descuento_directo_laboratorio, $total_descuento_laboratorio, $porcentaje_descuento_servicios, $descuento_directo_servicios, $total_descuento_servicios, $iva_ov, $total_productos, $precio_productos, $cargo_extra_productos, $porcentaje_descuento_productos, $descuento_directo_productos, $total_descuento_productos, $motivo_extras_consulta,$motivo_extras_imagen,$motivo_extras_lab,$motivo_extras_servicios,$motivo_extras_farmacia)";
   
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
 if (!$update) {echo $sql;}
 else{ 
	mysql_select_db($database_horizonte, $horizonte);
 	$resultR4 =mysql_query("SELECT referencia_ov from orden_venta order by id_ov desc limit 1 ", $horizonte) or die(mysql_error());
 	$rowR4 = mysql_fetch_row($resultR4); $la_refe = sqlValue($rowR4[0], "text");
	
	mysql_select_db($database_horizonte, $horizonte);
	$consulta = "SELECT id_vc, id_conceptos_beneficios, id_concepto_es from venta_conceptos where no_temp_vc = $aleatorio";
	$query = mysql_query($consulta) or die (mysql_error());
	
	$c = 0;
	while ($fila = mysql_fetch_array($query)) { $c++;
		$id = $fila['id_vc'];  $idCB = $fila['id_conceptos_beneficios'];
		$idConcepto = $fila['id_concepto_es']; 
		$refi = "-".$c; 
		$referencia = sqlValue($rowR4[0], "text").sqlValue($refi, "text");
		$referencia = sqlValue(str_replace("'","",$referencia), "text");$referenciaOV = sqlValue($rowR4[0], "text");
		$sql1 = "UPDATE venta_conceptos SET temporal_vc = 0, referencia_vc = $referenciaOV, contador_vc = $c where id_vc = $id";
		//Ahora actualizamos la fecha de usado del concepto del beneficio dle paciente
		$sqlCB = "UPDATE conceptos_beneficios SET usado_cb = 1, fecha_usado_cb = $now where id_cb = $idCB limit 1";
 
 		mysql_select_db($database_horizonte, $horizonte);
 		$insertar = mysql_query($sql1, $horizonte) or die (mysql_error());
		
		mysql_select_db($database_horizonte, $horizonte);
 		$insertarCB = mysql_query($sqlCB, $horizonte) or die (mysql_error());
		
		// si el concepto es de farmacia buscamos el registro mas viejo  que aun tenga existencias
		$banderaExistencias = false;
		$idExistencias = 0;
		$cantExistencias = 0;
		//comprobamos si el concepto pertenece a farmacia
		mysql_select_db($database_horizonte, $horizonte);
		$farm = mysql_query("SELECT id_to FROM conceptos WHERE id_tipo_concepto_to = 5 and id_to = $idConcepto", $horizonte) or die (mysql_error());
		$esProd = mysql_fetch_row($farm);

		if($esProd[0] != ''){
			//verificamos si tiene existencias 
			mysql_select_db($database_horizonte, $horizonte);
			$ext = "SELECT s.id, s.existencias from stock_has_bach s left join conceptos c  on c.id_to = s.id_Producto left join stock  s1 on s1.id = s.id_stock where s.id_Producto = $idConcepto AND s1.id_su = $id_sucu order by s.id DESC";
			$existen = mysql_query($ext, $horizonte) or die (mysql_error());
			while ($stock = mysql_fetch_assoc($existen)){
				if($stock['existencias'] >= 1 ){
					$idExistencias =  $stock['id'];
					$cantExistencias = $stock['existencias'];
					$banderaExistencias = true;
				}else{
					if($idExistencias != 0){
						$banderaExistencias = true;
					}
				}
			}

			if($banderaExistencias){
				mysql_select_db($database_horizonte, $horizonte);
				$menos = "UPDATE stock_has_bach SET existencias = (existencias -1) where id = $idExistencias";
				$resta_existencias = mysql_query($menos, $horizonte) or die (mysql_error());
			}

		}


	}; $conti = 0;
	
	if($_POST["pago_ov_c"]>0 and $_POST["pago_ov_c"]!=''){
		$sqlF = "INSERT INTO pagos_ov(pago_pag, usuario_pag, fecha_pag, referencia_pag, no_temp_pag, forma_pago_pag, caja, departamento_pa) VALUES ($pago_ov_a, $idU, $now, $la_refe, $aleatorio, $forma_pago_ov, $caja_ov, '4') ";
		mysql_select_db($database_horizonte, $horizonte); $insertarF = mysql_query($sqlF, $horizonte) or die (mysql_error()); $conti++;
	}
	if($_POST["pago_ov_i"]>0 and $_POST["pago_ov_i"]!=''){
		$sqlF1 = "INSERT INTO pagos_ov(pago_pag, usuario_pag, fecha_pag, referencia_pag, no_temp_pag, forma_pago_pag, caja, departamento_pa) VALUES ($pago_ov_i, $idU, $now, $la_refe, $aleatorio, $forma_pago_ov, $caja_ov, '2') ";
		mysql_select_db($database_horizonte, $horizonte); $insertarF1 = mysql_query($sqlF1, $horizonte) or die (mysql_error()); $conti++;
	}
	if($_POST["pago_ov_l"]>0 and $_POST["pago_ov_l"]!=''){
		$sqlF2 = "INSERT INTO pagos_ov(pago_pag, usuario_pag, fecha_pag, referencia_pag, no_temp_pag, forma_pago_pag, caja, departamento_pa) VALUES ($pago_ov_l, $idU, $now, $la_refe, $aleatorio, $forma_pago_ov, $caja_ov, '1') ";
		mysql_select_db($database_horizonte, $horizonte); $insertarF2 = mysql_query($sqlF2, $horizonte) or die (mysql_error()); $conti++;
	}
	if($_POST["pago_ov_f"]>0 and $_POST["pago_ov_f"]!=''){
		$sqlF3 = "INSERT INTO pagos_ov(pago_pag, usuario_pag, fecha_pag, referencia_pag, no_temp_pag, forma_pago_pag, caja, departamento_pa) VALUES ($pago_ov_f, $idU, $now, $la_refe, $aleatorio, $forma_pago_ov, $caja_ov, '3') ";
		mysql_select_db($database_horizonte, $horizonte); $insertarF3 = mysql_query($sqlF3, $horizonte) or die (mysql_error()); $conti++;
	}
	 
	if($conti == 0){
		$sqlF4 = "INSERT INTO pagos_ov(pago_pag, usuario_pag, fecha_pag, referencia_pag, no_temp_pag, forma_pago_pag, caja, departamento_pa) VALUES ('0', $idU, $now, $la_refe, $aleatorio, $forma_pago_ov, $caja_ov, '1') ";
		mysql_select_db($database_horizonte, $horizonte); $insertarF4 = mysql_query($sqlF4, $horizonte) or die (mysql_error());
	}
	 
	//Si todos los pagos son igual a cero, debemos poner por lo menos un pago igual a cero para que la orden se vea en corte de caja.
	echo '1'.';]'.$rowR4[0];
 }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>
