<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

include_once '../../recursos/session.php';
include_once '../../Connections/database.php';
include_once '../../recursos/utilities.php';

 $idS = sqlValue($_POST["id_s"], "int"); $tempN = sqlValue($_POST["tempo"], "text");
 $id_us = $_SESSION['id']; $now = sqlValue(date('Y-m-d H:i:s'), "date");
 
 	mysql_select_db($database_horizonte, $horizonte);
 	$result = mysql_query("SELECT id_su, clave_su, nombre_su, p_tabulador_i_su, p_tabulador_l_su, p_tabulador_s_su, estado_su, municipio_su, ciudad_su, colonia_su, calle_su, cp_su, X(GeomFromText(AsText(coordenadas_su))), Y(GeomFromText(AsText(coordenadas_su))), telefono_su, email_su, id_su, id_su, horario_e_lu, horario_s_lu, horario_e_ma, horario_s_ma, horario_e_mi, horario_s_mi, horario_e_ju, horario_s_ju, horario_e_vi, horario_s_vi, horario_e_sa, horario_s_sa, horario_e_do, horario_s_do, tipo_tabulador_su, tipo_tabulador_i_su, p_boni_monedero_c, clues_su, p_boni_monedero_i, p_boni_monedero_l, p_boni_monedero_s, p_boni_monedero_f, no_temp_su, margen_e_cm, tamano_h_cm, margen_p_cm, margen_e_rm, tamano_h_rm, margen_p_rm, margen_e_la, tamano_h_la, margen_p_la, margen_e_im, tamano_h_im, margen_p_im, margen_e_en, tamano_h_en, margen_p_en, margen_e_ul, tamano_h_ul, margen_p_ul, margen_e_co, tamano_h_co, margen_p_co, margen_e_sm, tamano_h_sm, margen_p_sm, formato_co_su, formato_nm_su, formato_la_su, formato_im_su, formato_en_su, formato_ul_su, formato_cp_su, formato_sm_su, razon_social_sf, rfc_sf, email_sf,telefono_sf, entidadFederativa_sf, municipio_sf, ciudad_sf, colonia_sf, calle_sf, cp_sf from sucursales where id_su = $idS ", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result);
	
	if($row[40]==NULL or $row[40]=='NULL'){
		$row[40] = $_POST["tempo"]; $temp_u = sqlValue($_POST["tempo"], "text");
		
		$sqlUU = "UPDATE sucursales SET no_temp_su = $temp_u where id_su = $idS limit 1";
  	    mysql_select_db($database_horizonte, $horizonte); $insertarUU = mysql_query($sqlUU, $horizonte) or die (mysql_error());	
	}else{ }
				 
 	$datos = $row[0].";-}{".$row[1].";-}{".$row[2].";-}{".$row[3].";-}{".$row[4].";-}{".$row[5].";-}{".$row[6].";-}{".$row[7].";-}{".$row[8].";-}{".$row[9].";-}{".$row[10].";-}{".$row[11].";-}{".$row[12].";-}{".$row[13].";-}{".$row[14].";-}{".$row[15].";-}{".$row[16].";-}{".$row[17].";-}{".$row[18].";-}{".$row[19].";-}{".$row[20].";-}{".$row[21].";-}{".$row[22].";-}{".$row[23].";-}{".$row[24].";-}{".$row[25].";-}{".$row[26].";-}{".$row[27].";-}{".$row[28].";-}{".$row[29].";-}{".$row[30].";-}{".$row[31].";-}{".$row[32].";-}{".$row[33].";-}{".$row[34].";-}{".$row[35].";-}{".$row[36].";-}{".$row[37].";-}{".$row[38].";-}{".$row[39].";-}{".$row[40].";-}{".$row[41].";-}{".$row[42].";-}{".$row[43].";-}{".$row[44].";-}{".$row[45].";-}{".$row[46].";-}{".$row[47].";-}{".$row[48].";-}{".$row[49].";-}{".$row[50].";-}{".$row[51].";-}{".$row[52].";-}{".$row[53].";-}{".$row[54].";-}{".$row[55].";-}{".$row[56].";-}{".$row[57].";-}{".$row[58].";-}{".$row[59].";-}{".$row[60].";-}{".$row[61].";-}{".$row[62].";-}{".$row[63].";-}{".$row[64].";-}{".$row[65].";-}{".$row[66].";-}{".$row[67].";-}{".$row[68].";-}{".$row[69].";-}{".$row[70].";-}{".$row[71].";-}{".$row[72].";-}{".$row[73].";-}{".$row[74].";-}{".$row[75].";-}{".$row[76].";-}{".$row[77].";-}{".$row[78].";-}{".$row[79].";-}{".$row[80].";-}{".$row[81].";-}{".$row[82];

echo $datos;
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>
