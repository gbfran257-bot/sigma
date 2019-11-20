<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

//datos generales
 list( $dia, $mes, $ano ) = explode( "/", $_POST['fnacP'] ); $raya = "-"; $f_nac = $ano.$raya.$mes.$raya.$dia." 00:00:00";

 $idU = sqlValue($_POST["idUsuarioP"], "int");
 $nombre = sqlValue($_POST["nombreP"], "text");
 $apaterno = sqlValue($_POST["apaternoP"], "text");
 $amaterno = sqlValue($_POST["amaternoP"], "text");
 $idSexo = sqlValue($_POST["sexoP"], "int");
 $nacionalidad = sqlValue($_POST["nacionalidadP"], "text");
 $fechaNacimiento = sqlValue($f_nac, "date");
 $tCelular = sqlValue($_POST["telmovilP"], "text");
 $tParticular = sqlValue($_POST["telparticularP"], "text");
 $curp = sqlValue($_POST["curpP"], "text");
 $rfc = sqlValue($_POST["rfcP"], "text");
 $idSucursal = sqlValue($_POST["sucursalP"], "int");

 $idP = sqlValue($_POST["idPacienteN"], "int");
 $razon = sqlValue($_POST["razonPF"], "text");
 $tSangreP = sqlValue($_POST["tSangreP"], "int");
 
 //Datos de dirección
 if(isset($_POST["estadoP"])){$estado = sqlValue($_POST["estadoP"], "int");}else{$estado = 'NULL';}
 if(isset($_POST["municipioP"])){$municipio = sqlValue($_POST["municipioP"], "int");}else{$municipio = 'NULL';}
 if(isset($_POST["coloniaP"])){$colonia = sqlValue($_POST["coloniaP"], "int");}else{$colonia = 'NULL';}
 if(isset($_POST["cpP"])){$cp = sqlValue($_POST["cpP"], "text");}else{$cp = 'NULL';}
 $calle = sqlValue($_POST["calleP"], "text");
 $noExt = sqlValue($_POST["noExtP"], "text");
 $noInt = sqlValue($_POST["noIntP"], "text");
 
 //Datos fiscales
 if(isset($_POST["estadoPF"])){$estadoF = sqlValue($_POST["estadoPF"], "int");}else{$estadoF = 'NULL';}
 if(isset($_POST["municipioPF"])){$municipioF = sqlValue($_POST["municipioPF"], "int");}else{$municipioF = 'NULL';}
 if(isset($_POST["coloniaPF"])){$coloniaF = sqlValue($_POST["coloniaPF"], "int");}else{$coloniaF = 'NULL';}
 if(isset($_POST["cpPF"])){$cpF = sqlValue($_POST["cpPF"], "text");}else{$cpF = 'NULL';}
 $calleF = sqlValue($_POST["callePF"], "text");
 $noExtF = sqlValue($_POST["noExtPF"], "text");
 $noIntF = sqlValue($_POST["noIntPF"], "text");
 
 //Datos de Contacto
 $telefonoTrabajo = sqlValue($_POST["telefonoTrabajoP"], "text");
 $extensionTT = sqlValue($_POST["extensionTelTraP"], "text");
 $email = sqlValue($_POST["emailPF"], "text");
  
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
  
 //DE LA FOTOGRAFÍA DE PERFIL DEL PACIENTE
 $foto = sqlValue($_POST["hayFoto"], "int");
 $nombreFoto = $_POST["nombreFotoT"].'.jpg';
 
 $entidadNacimiento = sqlValue($_POST["entidadNacimientoP"], "int");
 
 if($foto==1){$nombreFoto=$nombreFoto;}else{$nombreFoto='';$nombreFoto = sqlValue($nombreFoto, "text");}
 
 $rfcF = sqlValue($_POST["rfcPF"], "text");
 $idBanco = sqlValue($_POST["bancoPF"], "int");
 $digitos4 = sqlValue($_POST["digitos4B"], "text");

 mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO pacientes (idUsuarioR_p, nombre_p, apaterno_p, amaterno_p, sexo_p, nacionalidad_p, fNac_p, tCelular_p, tParticular_p, curp_p, rfc_p, idSucursal_p, entidadFederativa_p, municipio_p, colonia_p, cp_p, calle_p, noExt_p, noInt_p, tTrabajo_p, extensionTt_p, email_p,fechaR_p, foto_p, nombreFoto_p, entidad_nacimiento_p, razon_social_p, calle_pf, noExt_pf, noInt_pf, entidadFederativa_pf, municipio_pf, colonia_pf, cp_pf, rfc_f_p, id_banco_p, digitos_banco_p, tSanguineo_p)";
 $sql.= "VALUES ($idU, $nombre, $apaterno, $amaterno, $idSexo, $nacionalidad, $fechaNacimiento, $tCelular, $tParticular, $curp, $rfc, $idSucursal, $estado, $municipio, $colonia, $cp, $calle, $noExt, $noInt, $telefonoTrabajo, $extensionTT, $email, $now, $foto, '$nombreFoto', $entidadNacimiento, $razon, $calleF, $noExtF, $noIntF, $estadoF, $municipioF, $coloniaF, $cpF, $rfcF, $idBanco, $digitos4, $tSangreP)";
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
 if (!$update) {echo $sql;}
 else{ 
	mysql_select_db($database_horizonte, $horizonte);
 	$resultF = mysql_query("SELECT MAX(id_p) from pacientes limit 1 ", $horizonte) or die (mysql_error());
 	$rowF = mysql_fetch_row($resultF); $idPac = sqlValue($rowF[0], "int");
	
	/*mysql_select_db($database_horizonte, $horizonte);
	 $sqlCP = "INSERT INTO convenios_paciente (id_paciente_cvp, id_convenio_cvp, fecha_expedicion_cvp, fecha_expiracion_cvp, usuario_cvp, fecha_cvp)";
	 $sqlCP.= "VALUES ($idPac, 1, now(), '3000-01-01', 1, now())";
	 $updateCP = mysql_query($sqlCP, $horizonte) or die (mysql_error());*/
	
	mysql_select_db($database_horizonte, $horizonte);
 	$sqlH = "INSERT INTO historia_clinica (id_paciente_hc, id_usuario_hc, fecha_registro_hc) VALUES ($rowF[0], $idU, $now)";
 	$insertH = mysql_query($sqlH, $horizonte) or die (mysql_error());
	
	if (!$insertH) { echo $sqlH; }else{ echo 1; }
		
 }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>