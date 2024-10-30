<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");
mysql_select_db($database_horizonte, $horizonte);
 $idUsuario = sqlValue($_POST["idUsuarioP"], "int");
 $idSu = sqlValue($_POST["idSucursal"], "int");
 
 $temporal = sqlValue($_POST["temporal_s"], "text");
 if($_POST["p_latitud_s"]==''){$latitud = 0.0;}else{$latitud = $_POST["p_latitud_s"];}
 if($_POST["p_longitud_s"]==''){$longitud = 0.0;}else{$longitud = $_POST["p_longitud_s"];}
 
 $clave = sqlValue(mb_strtoupper($_POST["claveS"]), "text");
 $nombre = sqlValue(mb_strtoupper($_POST["nombreS"]), "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 $clues = sqlValue(mb_strtoupper($_POST["cluesS"]), "text");
 
 $porcentaje_t_i = sqlValue($_POST["p_tabu_img"], "int");
 $porcentaje_t_l = sqlValue($_POST["p_tabu_lab"], "int");
 $porcentaje_t_s = sqlValue($_POST["p_tabu_serv"], "int");
 $tab_img = sqlValue($_POST["t_base_img"], "int");
 $tab_lab = sqlValue($_POST["t_base_lab"], "int");
 
 $estado = sqlValue(mb_strtoupper($_POST["estadoP"]), "text");
 $municipio = sqlValue(mb_strtoupper($_POST["municipioP"]), "text");
 $ciudad = sqlValue(mb_strtoupper($_POST["ciudadP"]), "text");
 $colonia = sqlValue(mb_strtoupper($_POST["coloniaP"]), "text");
 $calle = sqlValue(mb_strtoupper($_POST["calleS"]), "text");
 $cp = sqlValue(mb_strtoupper($_POST["cpP"]), "text");
 
 $telefono = sqlValue(mb_strtoupper($_POST["telefonos_s"]), "text");
 $email = sqlValue(strtolower($_POST["email_s"]), "text");
   
 if($_POST["t_lunes"]==1){
 	$horario_lu_e = sqlValue($_POST["lunes_de1"], "text"); $horario_lu_s = sqlValue($_POST["lunes_a1"], "text");
 }else{ $horario_lu_e = sqlValue('00:00:01', "text"); $horario_lu_s = sqlValue('00:00:02', "text"); }
 if($_POST["t_martes"]==1){
	 $horario_ma_e = sqlValue($_POST["martes_de1"], "text"); $horario_ma_s = sqlValue($_POST["martes_a1"], "text");
 }else{ $horario_ma_e = sqlValue('00:00:01', "text"); $horario_ma_s = sqlValue('00:00:02', "text"); }
 if($_POST["t_miercoles"]==1){
	 $horario_mi_e = sqlValue($_POST["miercoles_de1"], "text"); $horario_mi_s = sqlValue($_POST["miercoles_a1"], "text");
 }else{ $horario_mi_e = sqlValue('00:00:01', "text"); $horario_mi_s = sqlValue('00:00:02', "text"); }
 if($_POST["t_jueves"]==1){
	 $horario_ju_e = sqlValue($_POST["jueves_de1"], "text"); $horario_ju_s = sqlValue($_POST["jueves_a1"], "text");
 }else{ $horario_ju_e = sqlValue('00:00:01', "text"); $horario_ju_s = sqlValue('00:00:02', "text"); }
 if($_POST["t_viernes"]==1){
	 $horario_vi_e = sqlValue($_POST["viernes_de1"], "text"); $horario_vi_s = sqlValue($_POST["viernes_a1"], "text");
 }else{ $horario_vi_e = sqlValue('00:00:01', "text"); $horario_vi_s = sqlValue('00:00:02', "text"); }
 if($_POST["t_sabado"]==1){
	 $horario_sa_e = sqlValue($_POST["sabado_de1"], "text"); $horario_sa_s = sqlValue($_POST["sabado_a1"], "text");
 }else{ $horario_sa_e = sqlValue('00:00:01', "text"); $horario_sa_s = sqlValue('00:00:02', "text"); }
 if($_POST["t_domingo"]==1){
	 $horario_do_e = sqlValue($_POST["domingo_de1"], "text"); $horario_do_s = sqlValue($_POST["domingo_a1"], "text");
 }else{ $horario_do_e = sqlValue('00:00:01', "text"); $horario_do_s = sqlValue('00:00:02', "text"); }
 
 $margen_e_cm = sqlValue($_POST["margen_en1"], "double");
 $tamano_h_cm = sqlValue($_POST["tam_mem1"], "int");
 $margen_p_cm = sqlValue($_POST["margen_pi1"], "double");
 
 $margen_e_rm = sqlValue($_POST["margen_en2"], "double");
 $tamano_h_rm = sqlValue($_POST["tam_mem2"], "int");
 $margen_p_rm = sqlValue($_POST["margen_pi2"], "double");
 
 $margen_e_la = sqlValue($_POST["margen_en3"], "double");
 $tamano_h_la = sqlValue($_POST["tam_mem3"], "int");
 $margen_p_la = sqlValue($_POST["margen_pi3"], "double");
 
 $margen_e_im = sqlValue($_POST["margen_en4"], "double");
 $tamano_h_im = sqlValue($_POST["tam_mem4"], "int");
 $margen_p_im = sqlValue($_POST["margen_pi4"], "double");
 
 $margen_e_en = sqlValue($_POST["margen_en5"], "double");
 $tamano_h_en = sqlValue($_POST["tam_mem5"], "int");
 $margen_p_en = sqlValue($_POST["margen_pi5"], "double");
 
 $margen_e_ul = sqlValue($_POST["margen_en6"], "double");
 $tamano_h_ul = sqlValue($_POST["tam_mem6"], "int");
 $margen_p_ul = sqlValue($_POST["margen_pi6"], "double");
 
 $margen_e_co = sqlValue($_POST["margen_en7"], "double");
 $tamano_h_co = sqlValue($_POST["tam_mem7"], "int");
 $margen_p_co = sqlValue($_POST["margen_pi7"], "double");
 
 $margen_e_sm = sqlValue($_POST["margen_en8"], "double");
 $tamano_h_sm = sqlValue($_POST["tam_mem8"], "int");
 $margen_p_sm = sqlValue($_POST["margen_pi8"], "double");
 
 $formato = sqlValue($_POST["input_a"], "text"); $formato1 = sqlValue($_POST["input_b"], "text"); $formato2 = sqlValue($_POST["input_c"], "text");
 $formato3 = sqlValue($_POST["input_d"], "text"); $formato4 = sqlValue($_POST["input_e"], "text"); $formato5 = sqlValue($_POST["input_f"], "text");
 $formato6 = sqlValue($_POST["input_g"], "text"); $formato7 = sqlValue($_POST["input_h"], "text");
 $sql2 = "select p_tabulador_i_su, p_tabulador_l_su, p_tabulador_s_su, tipo_tabulador_su from sucursales where id_su = $idSu limit 1";
 $insertI = mysql_query($sql2, $horizonte) or die (mysql_error());
 $row2 = mysql_fetch_row($result);
 //FISCALES 
 $razon_social_sf = sqlValue($_POST["rSocial"], "text");
 $rfc_sf = sqlValue($_POST["rfcSu"], "text");           
 $email_sf = sqlValue($_POST["emailFSu"], "text");         
 $telefono_sf = sqlValue($_POST["telFSu"], "text");     
//  $regimen_sf = sqlValue($_POST["input_a"], "text");     
 $entidadFederativa_sf = sqlValue($_POST["estadoSu"], "int");  
 $municipio_sf = sqlValue($_POST["municipioSu"], "int");     
 $ciudad_sf = sqlValue($_POST["ciudadFSu"], "text");          
 $colonia_sf = sqlValue($_POST["coloniaFSu"], "text");         
 $calle_sf = sqlValue($_POST["calleFSu"], "text");         
 $cp_sf =sqlValue($_POST["cpFSu"], "text");


 $sql = "UPDATE sucursales SET clave_su = $clave, nombre_su = $nombre, estado_su = $estado, municipio_su = $municipio, ciudad_su = $ciudad, colonia_su = $colonia, calle_su = $calle, cp_su = $cp, telefono_su = $telefono, email_su = $email, horario_e_lu = $horario_lu_e, horario_s_lu = $horario_lu_s, horario_e_ma = $horario_ma_e, horario_s_ma = $horario_ma_s, horario_e_mi = $horario_mi_e, horario_s_mi = $horario_mi_s, horario_e_ju = $horario_ju_e, horario_s_ju = $horario_ju_s, horario_e_vi = $horario_vi_e, horario_s_vi = $horario_vi_s, horario_e_sa = $horario_sa_e, horario_s_sa = $horario_sa_s, horario_e_do = $horario_do_e, horario_s_do = $horario_do_s, clues_su = $clues, margen_e_cm = $margen_e_cm, tamano_h_cm = $tamano_h_cm, margen_p_cm = $margen_p_cm, margen_e_rm = $margen_e_rm, tamano_h_rm = $tamano_h_rm, margen_p_rm = $margen_p_rm, margen_e_la = $margen_e_la, tamano_h_la = $tamano_h_la, margen_p_la = $margen_p_la, margen_e_im = $margen_e_im, tamano_h_im = $tamano_h_im, margen_p_im = $margen_p_im, margen_e_en = $margen_e_en, tamano_h_en = $tamano_h_en, margen_p_en = $margen_p_en, margen_e_ul = $margen_e_ul, tamano_h_ul = $tamano_h_ul, margen_p_ul = $margen_p_ul, margen_e_co = $margen_e_co, tamano_h_co = $tamano_h_co, margen_p_co = $margen_p_co, margen_e_sm = $margen_e_sm, tamano_h_sm = $tamano_h_sm, margen_p_sm = $margen_p_sm, formato_co_su = $formato, formato_nm_su = $formato1, formato_la_su = $formato2, formato_im_su = $formato3, formato_en_su = $formato4, formato_ul_su = $formato5, formato_cp_su = $formato6, formato_sm_su = $formato7, p_tabulador_i_su = $porcentaje_t_i, p_tabulador_l_su = $porcentaje_t_l, p_tabulador_s_su = $porcentaje_t_s, tipo_tabulador_su = $tab_lab, tipo_tabulador_i_su = $tab_img, razon_social_sf = $razon_social_sf, rfc_sf = $rfc_sf, email_sf = $email_sf, telefono_sf = $telefono_sf, entidadFederativa_sf = $entidadFederativa_sf, municipio_sf = $municipio_sf, ciudad_sf = $ciudad_sf, colonia_sf = $colonia_sf, calle_sf = $calle_sf, cp_sf = $cp_sf where id_su = $idSu limit 1";
 //
  

$insertar = mysql_query($sql, $horizonte);
 	
if(!$insertar){ echo $sql; }else{
	mysql_select_db($database_horizonte, $horizonte);
	$sqlI = "UPDATE documentos set id_quien_do = $idSu where aleatorio_do = $temporal";
	$insertI = mysql_query($sqlI, $horizonte) or die (mysql_error());
	if (!$insertI) { echo $sqlI; }else{
		$k1 = $idSu.'_precio'; $k2 = $idSu.'_precio_u';
		//Para imagen
		/*if($row2[0]!=$porcentaje_t_i){
			$uno = $porcentaje_t_i*0.01;
			if($tab_img==1){//tabulador base maquila
				$sql2 = "update conceptos set $k1 = precio_to*$uno, $k2 = precio_urgencia_to*$uno where id_tipo_concepto_to = 4";
			}else{//tabulador base sucursal
				$sql2 = "update conceptos set $k1 = precio_to*$uno, $k2 = precio_urgencia_to*$uno where id_tipo_concepto_to = 4";
			}
			$update2 = mysql_query($sql2, $horizonte);
		}*/
		//Para laboratorio
		if($row2[3]!=$tab_lab){ /// hubo cambio
			if($tab_lab==1){//tabulador base maquila
				$sql3 = "update conceptos set $k1 = costo_maquila_to, $k2 = costo_maquila_u_to where id_tipo_concepto_to = 3";
			}else{//tabulador base sucursal
				$sql3 = "update conceptos set $k1 = precio_to, $k2 = precio_urgencia_to where id_tipo_concepto_to = 3";
			}
			$update3 = mysql_query($sql3, $horizonte);
		}
		//Para servicios
		/*if($row2[2]!=$porcentaje_t_s){
			$tres = $porcentaje_t_l*0.01;
			$sql4 = "update conceptos set $k1 = precio_to*$tres, $k2 = precio_urgencia_to*$tres where id_tipo_concepto_to = 2";
			/$update4 = mysql_query($sql4, $horizonte);
		}*/
		echo 1;
	}
}
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>
