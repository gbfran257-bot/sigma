<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 list( $dia, $mes, $ano ) = explode( "/", $_POST['fecha_nacimiento_p'] ); $raya = "-"; $f_nac = $ano.$raya.$mes.$raya.$dia." 00:00:00";

 $idU = sqlValue($_POST["id_usr_reg"], "int");
 $id_sucu = sqlValue($_POST["id_sucu"], "int");
 $nombre = sqlValue(mb_strtoupper(trim($_POST["nombre_p"])), "text");
 $apaterno = sqlValue(mb_strtoupper(trim($_POST["apaterno_p"])), "text");
 $amaterno = sqlValue(mb_strtoupper(trim($_POST["amaterno_p"])), "text");
 $fechaNacimiento = sqlValue($f_nac, "date");
 $idSexo = sqlValue($_POST["sexo_us"], "int");
 $id_pais = sqlValue($_POST["pais_p"], "int");
 $entidadNacimiento = sqlValue($_POST["edo_nacimiento"], "int");
 $curp = sqlValue(mb_strtoupper($_POST["curp_p"]), "text");
 $rfc = sqlValue(mb_strtoupper($_POST["rfc_p"]), "text");
 $tCelular = sqlValue(mb_strtoupper($_POST["tel_personal_p"]), "text");
 $tParticular = sqlValue(mb_strtoupper($_POST["tel_particular_p"]), "text");
 $telefonoTrabajo = sqlValue(mb_strtoupper($_POST["tel_trabajo_p"]), "text");
 $extensionTT = sqlValue(mb_strtoupper($_POST["tel_trabajo_ext_p"]), "text");
 $email = sqlValue(strtolower($_POST["email_p"]), "text");
 $tSangreP = sqlValue($_POST["sangre_p"], "int");
 $avisara = sqlValue(mb_strtoupper($_POST["contacto_emergencia_p"]), "text");
 $temergencia = sqlValue(mb_strtoupper($_POST["tel_emergencia_p"]), "text");
 $nombre_completo = trim($_POST["nombre_p"]).' '.trim($_POST["apaterno_p"]).' '.trim($_POST["amaterno_p"]);
 $nombre_completo = sqlValue(mb_strtoupper($nombre_completo), "text");
 
 //Datos de dirección
 if(isset($_POST["estado_dir_p"])){$estado = sqlValue($_POST["estado_dir_p"], "int");}else{$estado = 'NULL';}
 if(isset($_POST["municipio_p"])){$municipio = sqlValue($_POST["municipio_p"], "int");}else{$municipio = 'NULL';}
 $ciudad = sqlValue(mb_strtoupper($_POST["ciudad_us"]), "text");
 $colonia = sqlValue(mb_strtoupper($_POST["colonia_us"]), "text");
 $calle = sqlValue(mb_strtoupper($_POST["calle_us"]), "text");
 $cp = sqlValue(mb_strtoupper($_POST["cp_us"]), "text");
 if(isset($_POST["lati_ud"]) && !empty($_POST["lati_ud"])){$latitud = $_POST["lati_ud"];}else{$latitud = 18.8161;}
 if(isset($_POST["long_ud"]) && !empty($_POST["long_ud"])){$longitud = $_POST["long_ud"];}else{$longitud = -98.954;}
 
 //Datos fiscales
 $razon = sqlValue(mb_strtoupper($_POST["razon_social"]), "text");
 $rfcF = sqlValue(mb_strtoupper($_POST["rfc_fp"]), "text"); 
 $email_pf = sqlValue(strtolower($_POST["email_pf"]), "text"); 
 if(isset($_POST["estado_df"])){$estadoF = sqlValue($_POST["estado_df"], "int");}else{$estadoF = 'NULL';}
 if(isset($_POST["municipio_df"])){$municipioF = sqlValue($_POST["municipio_df"], "int");}else{$municipioF = 'NULL';}
 $ciudadF = sqlValue(mb_strtoupper($_POST["ciudad_df"]), "text");
 $coloniaF = sqlValue(mb_strtoupper($_POST["colonia_df"]), "text");
 $calleF = sqlValue(mb_strtoupper($_POST["calle_df"]), "text");
 $cpF = sqlValue(mb_strtoupper($_POST["cp_df"]), "text");
 
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 //DE LA FOTOGRAFÍA DE PERFIL DEL PACIENTE $no_temp = sqlValue($_POST["temporal_s"], "text");
 //$idBanco = sqlValue($_POST["bancoPF"], "int"); $digitos4 = sqlValue($_POST["digitos4B"], "text");
  
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO pacientes (idUsuarioR_p, nombre_p, apaterno_p, amaterno_p, sexo_p, nacionalidad_p, fNac_p, tCelular_p, tParticular_p, curp_p, rfc_p, idSucursal_p, entidadFederativa_p, municipio_p, ciudad_p, colonia_p, cp_p, calle_p, tTrabajo_p, extensionTt_p, email_p, fechaR_p, entidad_nacimiento_p, razon_social_p, calle_pf, entidadFederativa_pf, municipio_pf, ciudad_pf, colonia_pf, cp_pf, rfc_f_p, tSanguineo_p, nombre_completo_p, coordenadas_p, email_pf, contactoEmergencia_p, tEmergencia_p )";
 $sql.= "VALUES ($idU, $nombre, $apaterno, $amaterno, $idSexo, $id_pais, $fechaNacimiento, $tCelular, $tParticular, $curp, $rfc, $id_sucu, $estado, $municipio, $ciudad, $colonia, $cp, $calle, $telefonoTrabajo, $extensionTT, $email, $now, $entidadNacimiento, $razon, $calleF, $estadoF, $municipioF, $ciudadF, $coloniaF, $cpF, $rfcF, $tSangreP, $nombre_completo, GeomFromText('POINT($latitud $longitud)'), $email_pf, $avisara, $temergencia )";
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
 if (!$update) {echo $sql;}
 else{ 
	mysql_select_db($database_horizonte, $horizonte);
 	$resultF = mysql_query("SELECT MAX(id_p) from pacientes limit 1 ", $horizonte) or die (mysql_error());
 	$rowF = mysql_fetch_row($resultF); $idPac = sqlValue($rowF[0], "int");
		
	mysql_select_db($database_horizonte, $horizonte);
 	$sqlH = "INSERT INTO historia_clinica (id_paciente_hc, id_usuario_hc, fecha_registro_hc) VALUES ($rowF[0], $idU, $now)";
 	$insertH = mysql_query($sqlH, $horizonte) or die (mysql_error());
	
	if (!$insertH) { echo $sqlH; }else{ echo '1'.';-:'.$rowF[0].';-:'.$_POST["nombre_p"].' '.$_POST["apaterno_p"].' '.$_POST["amaterno_p"]; }
 }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>
