<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $temporal = sqlValue($_POST["temporal_s"], "text");
 $latitud = $_POST["p_latitud_s"]; $longitud = $_POST["p_longitud_s"];
 $idUsuario = sqlValue($_POST["idUsuarioP"], "int");
 
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
 
 /*$p_m_c = sqlValue($_POST["p_m_c"], "int");$p_m_i = sqlValue($_POST["p_m_i"], "int");$p_m_l = sqlValue($_POST["p_m_l"], "int");
 $p_m_s = sqlValue($_POST["p_m_s"], "int");$p_m_f = sqlValue($_POST["p_m_f"], "int");*/
 //,p_boni_monedero_c, p_boni_monedero_i, p_boni_monedero_l, p_boni_monedero_s, p_boni_monedero_f,$p_m_c,$p_m_i,$p_m_l,$p_m_s,$p_m_f

 mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO sucursales (usuario_su, clave_su, nombre_su, no_temp_su, fecha_su, estado_su, municipio_su, ciudad_su, colonia_su, calle_su, cp_su, telefono_su, email_su, p_tabulador_i_su, p_tabulador_l_su, p_tabulador_s_su, coordenadas_su, horario_e_lu, horario_s_lu, horario_e_ma, horario_s_ma, horario_e_mi, horario_s_mi, horario_e_ju, horario_s_ju, horario_e_vi, horario_s_vi, horario_e_sa, horario_s_sa, horario_e_do, horario_s_do, tipo_tabulador_su, tipo_tabulador_i_su, clues_su, margen_e_cm, tamano_h_cm, margen_p_cm, margen_e_rm, tamano_h_rm, margen_p_rm, margen_e_la, tamano_h_la, margen_p_la, margen_e_im, tamano_h_im, margen_p_im, margen_e_en, tamano_h_en, margen_p_en, margen_e_ul, tamano_h_ul, margen_p_ul, margen_e_co, tamano_h_co, margen_p_co, margen_e_sm, tamano_h_sm, margen_p_sm, formato_co_su, formato_nm_su, formato_la_su, formato_im_su, formato_en_su, formato_ul_su, formato_cp_su, formato_sm_su)";
 $sql.= "VALUES ($idUsuario, $clave, $nombre, $temporal, $now, $estado, $municipio, $ciudad, $colonia, $calle, $cp, $telefono, $email, $porcentaje_t_i, $porcentaje_t_l, $porcentaje_t_s, GeomFromText('POINT($latitud $longitud)'), $horario_lu_e, $horario_lu_s, $horario_ma_e, $horario_ma_s, $horario_mi_e, $horario_mi_s, $horario_ju_e, $horario_ju_s, $horario_vi_e, $horario_vi_s, $horario_sa_e, $horario_sa_s, $horario_do_e, $horario_do_s, $tab_lab, $tab_img,$clues, $margen_e_cm, $tamano_h_cm, $margen_p_cm, $margen_e_rm, $tamano_h_rm, $margen_p_rm, $margen_e_la, $tamano_h_la, $margen_p_la, $margen_e_im, $tamano_h_im, $margen_p_im, $margen_e_en, $tamano_h_en, $margen_p_en, $margen_e_ul, $tamano_h_ul, $margen_p_ul, $margen_e_co, $tamano_h_co, $margen_p_co, $margen_e_sm, $tamano_h_sm, $margen_p_sm, $formato, $formato1, $formato2, $formato3, $formato4, $formato5, $formato6, $formato7)";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) { echo $sql; }else{
	mysql_select_db($database_horizonte, $horizonte);
	$result=mysql_query("SELECT max(id_su) FROM sucursales", $horizonte) or die(mysql_error()); $row=mysql_fetch_row($result);
	$idSucu = sqlValue($row[0], "int");
	
	mysql_select_db($database_horizonte, $horizonte);
	$sqlI = "UPDATE documentos set id_quien_do = $idSucu where aleatorio_do = $temporal";
	$insertI = mysql_query($sqlI, $horizonte) or die (mysql_error());
	if (!$insertI) { echo $sqlI; }else{
		$k1 = $row[0].'_precio'; $k2 = $row[0].'_precio_u'; $k3 = $row[0].'_precio_mem'; $k4 = $row[0].'_precio_mem_u';
		$k5 = $row[0].'_precio_hos'; $k6 = $row[0].'_precio_hos_mem'; $k7 = $row[0].'_costo_maquila';
		$k8 = $row[0].'_costo_maquila_u'; $k9 = $row[0].'_costo_produccion'; $k10 = $row[0].'_dias_entrega';
		$k11 = $row[0].'_formato';
	
		$sql1 = "ALTER TABLE conceptos ADD $k1 FLOAT(8,2) UNSIGNED NOT NULL, ADD $k2 FLOAT(8,2) UNSIGNED NOT NULL";
		$update1 = mysql_query($sql1, $horizonte) or die (mysql_error());
		
		if (!$update1) { echo $sql1; }else{ $uno = $porcentaje_t_i*0.01;
			//Para imagen
			if($_POST["tab_img"]==1){//tabulador base maquila
				$sql2 = "update conceptos set $k1 = precio_to*$uno, $k2 = precio_urgencia_to*$uno where id_tipo_concepto_to = 4";
			}else{//tabulador base sucursal
				$sql2 = "update conceptos set $k1 = precio1_to*$uno, $k2 = precio_urgencia1_to*$uno where id_tipo_concepto_to = 4";
			}
			//Para laboratorio
			$update2 = mysql_query($sql2, $horizonte) or die (mysql_error());
			if (!$update2) { echo $sql2; }else{ $dos = $porcentaje_t_l*0.01;
				if($_POST["tab_lab"]==1){//tabulador base maquila
					$sql3 = "update conceptos set $k1 = precio_to*$dos, $k2 = precio_urgencia_to*$dos where id_tipo_concepto_to = 3";
				}else{//tabulador base sucursal
					$sql3 = "update conceptos set $k1 = precio1_to*$dos, $k2 = precio_urgencia1_to*$dos where id_tipo_concepto_to = 3";
				}
				//Para servicios
				$update3 = mysql_query($sql3, $horizonte) or die (mysql_error());
				if (!$update3) { echo $sql3; }else{ $tres = $porcentaje_t_s*0.01;
					$sql4 = "update conceptos set $k1 = precio_to*$tres, $k2 = precio_urgencia_to*$tres where id_tipo_concepto_to = 2";
					$update4 = mysql_query($sql4, $horizonte) or die (mysql_error());
					if (!$update4) { echo $sql4; }else{echo 1; }
				}
			}
		}
	}
	//ALTER TABLE conceptos ADD 1_precio FLOAT(8,2) UNSIGNED NOT NULL , ADD 1_precio_u FLOAT(8,2) UNSIGNED NOT NULL , ADD 1_precio_mem FLOAT(8,2) UNSIGNED NOT NULL , ADD 1_precio_mem_u FLOAT(8,2) UNSIGNED NOT NULL , ADD 1_precio_hos FLOAT(8,2) UNSIGNED NOT NULL , ADD 1_precio_hos_mem FLOAT(8,2) UNSIGNED NOT NULL , ADD 1_costo_maquila FLOAT(8,2) UNSIGNED NULL DEFAULT NULL , ADD 1_costo_maquila_u FLOAT(8,2) UNSIGNED NULL DEFAULT NULL , ADD 1_costo_produccion FLOAT(8,2) UNSIGNED NULL DEFAULT NULL , ADD 1_dias_entrega TINYINT UNSIGNED NULL DEFAULT NULL , ADD 1_formato TEXT CHARACTER SET latin1 COLLATE latin1_spanish_ci NULL DEFAULT NULL ;
}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>