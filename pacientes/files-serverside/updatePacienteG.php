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
 $idSucursal = sqlValue($_POST["sucursalP"], "int"); // idSucursal_p = $idSucursal
 $centroSaludP = sqlValue($_POST["centroSaludP"], "int");
 $derechohabiencia = sqlValue($_POST["derechohabienciaP"], "int");

 $idP = sqlValue($_POST["idPacienteN"], "int");
 $razon = sqlValue($_POST["razonPF"], "text");
 $tSangreP = sqlValue($_POST["tSangreP"], "int");
 
 $nombre_completo = $_POST["nombreP"].' '.$_POST["apaternoP"].' '.$_POST["amaternoP"];
 $nombre_completo = sqlValue($nombre_completo, "text");
 
 //Datos de dirección
 if(isset($_POST["estadoP"])){$estado = sqlValue($_POST["estadoP"], "int");}else{$estado = 'NULL';}
 if(isset($_POST["municipioP"])){$municipio = sqlValue($_POST["municipioP"], "int");}else{$municipio = 'NULL';}
 if(isset($_POST["coloniaP"])){$colonia = sqlValue($_POST["coloniaP"], "int");}else{$colonia = 'NULL';}
 if(isset($_POST["cpP"])){$cp = sqlValue($_POST["cpP"], "text");}else{$cp = 'NULL';}
 $calle = sqlValue($_POST["calleP"], "text");
 
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
 $foto = sqlValue($_POST["fotoU"], "int");
 $no_temp = sqlValue($_POST["temporal_s"], "text");
 
 $entidadNacimiento = sqlValue($_POST["entidadNacimientoP"], "int");
 
 $rfcF = sqlValue($_POST["rfcPF"], "text");
 $idBanco = sqlValue($_POST["bancoPF"], "int");
 $digitos4 = sqlValue($_POST["digitos4B"], "text");
 
 $latitud = $_POST["p_latitud_s"]; $longitud = $_POST["p_longitud_s"];
 
 $nssP = sqlValue($_POST["nssP"], "text");
  
 $sql = "UPDATE pacientes SET foto_p = $foto, coordenadas_p = GeomFromText('POINT($latitud $longitud)'), curp_p = $curp, nombre_p = $nombre, apaterno_p = $apaterno, amaterno_p = $amaterno, tCelular_p = $tCelular, tParticular_p = $tParticular, rfc_p = $rfc, sexo_p = $idSexo, fNac_p = $fechaNacimiento, nacionalidad_p = $nacionalidad, entidadFederativa_p = $estado, municipio_p = $municipio, colonia_p = $colonia, cp_p = $cp, calle_p= $calle, tTrabajo_p = $telefonoTrabajo, extensionTt_p = $extensionTT, email_p = $email, entidad_nacimiento_p = $entidadNacimiento, razon_social_p = $razon, calle_pf = $calleF, noExt_pf = $noExtF, noInt_pf = $noIntF, entidadFederativa_pf = $estadoF, municipio_pf = $municipioF, colonia_pf = $coloniaF, cp_pf = $cpF, rfc_f_p = $rfcF, id_banco_p = $idBanco, digitos_banco_p = $digitos4, tSanguineo_p = $tSangreP, centro_salud_p = $centroSaludP, nombre_completo_p = $nombre_completo, derechohabiencia_p = $derechohabiencia, no_seguridad_social_p = $nssP where id_p = $idP limit 1";
 
 mysql_select_db($database_horizonte, $horizonte);
 $insertar = mysql_query($sql, $horizonte) or die (mysql_error());
 	
 if (!$insertar) { echo $sql;}else {echo 1;}
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>