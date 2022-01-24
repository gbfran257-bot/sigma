<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 list( $dia, $mes, $ano ) = explode( "/", $_POST['fecha_nacimiento_p'] ); $raya = "-"; $f_nac = $ano.$raya.$mes.$raya.$dia." 00:00:00";

 $idP = sqlValue($_POST["id_paciente_v"], "int");
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
 if(isset($_POST["lati_ud"])){$latitud = $_POST["lati_ud"];}else{$latitud = 18.8161;}
 if(isset($_POST["long_ud"])){$longitud = $_POST["long_ud"];}else{$longitud = -98.954;}
 
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
 $sql = "UPDATE pacientes set nombre_p = $nombre, apaterno_p = $apaterno, amaterno_p = $amaterno, sexo_p = $idSexo, nacionalidad_p = $id_pais, fNac_p = $fechaNacimiento, tCelular_p = $tCelular, tParticular_p = $tParticular, curp_p = $curp, rfc_p = $rfc, entidadFederativa_p = $estado, municipio_p = $municipio, ciudad_p = $ciudad, colonia_p = $colonia, cp_p = $cp, calle_p = $calle, tTrabajo_p = $telefonoTrabajo, extensionTt_p = $extensionTT, email_p = $email, entidad_nacimiento_p = $entidadNacimiento, razon_social_p = $razon, calle_pf = $calleF, entidadFederativa_pf = $estadoF, municipio_pf = $municipioF, ciudad_pf = $ciudadF, colonia_pf = $coloniaF, cp_pf = $cpF, rfc_f_p = $rfcF, tSanguineo_p = $tSangreP, nombre_completo_p = $nombre_completo, coordenadas_p = GeomFromText('POINT($latitud $longitud)'), email_pf = $email_pf, contactoEmergencia_p = $avisara, tEmergencia_p = $temergencia where id_p = $idP limit 1 ";
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
 mysql_select_db($database_horizonte, $horizonte);
$rep ="UPDATE documentos set aleatorio_do = $idP, id_quien_do  = $idP where aleatorio_do = $idP";
$re = mysql_query($rep, $horizonte) or die (mysql_error());

 if(!$update){echo $sql;} else{ echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>
