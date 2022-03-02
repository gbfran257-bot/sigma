<?php
require("../Connections/horizonte.php");
require("../funciones/php/values.php");

$usuario = sqlValue($_POST["id_u_cf"], "int");
$nombreS = sqlValue($_POST["nombreS"], "text");
$nombreDB = sqlValue($_POST["nombreDB"], "text");
$nombreM = sqlValue(mb_strtoupper($_POST["nombreM"]), "text");
$precioM = sqlValue($_POST["precioM"], "double");
$periodoM = sqlValue($_POST["periodoM"], "text");
$diasMV = sqlValue($_POST["diasMV"], "int");
$now = sqlValue(date('Y-m-d H:i:s'), "date");
$tecla = sqlValue($_POST["teclaP"], "text");
$formato = sqlValue($_POST["input_a"], "text"); $formato1 = sqlValue($_POST["input_b"], "text"); $formato2 = sqlValue($_POST["input_c"], "text");
$formato3 = sqlValue($_POST["input_d"], "text"); $formato4 = sqlValue($_POST["input_e"], "text"); $formato5 = sqlValue($_POST["input_f"], "text");
$formato6 = sqlValue($_POST["input_g"], "text"); $formato7 = sqlValue($_POST["input_h"], "text");
$link_local_s = sqlValue($_POST["link_local_s"], "text");
$link_local_p = sqlValue($_POST["link_local_p"], "text");
$link_externo_s = sqlValue($_POST["link_externo_s"], "text");
$link_externo_p = sqlValue($_POST["link_externo_p"], "text");
$sitio_web = sqlValue($_POST["sitio_web"], "text");


 //FISCALES 
 $razon_social_cf = sqlValue($_POST["rSocial"], "text");
 $rfc_cf = sqlValue($_POST["rfc_cf"], "text");           
 $email_cf = sqlValue($_POST["email_cf"], "text");         
 $telefono_cf = sqlValue($_POST["telefono_cf"], "text");      
 $entidadFederativa_cf = sqlValue($_POST["entidadFederativa_cf"], "int");  
 $municipio_cf = sqlValue($_POST["municipio_cf"], "int");     
 $ciudad_cf = sqlValue($_POST["ciudad_cf"], "text");          
 $colonia_cf = sqlValue($_POST["colonia_cf"], "text");         
 $calle_cf = sqlValue($_POST["calle_cf"], "text");         
 $cp_cf =sqlValue($_POST["cp_cf"], "text");

mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO configuracion(nombre_sistema_cf, nombre_db_cf, nombre_membresia_cf, precio_membresia_cf, periodo_membresia_cf, dias_avisar_membresia_cf, usuario_cf, fecha_cf, tecla_cf, formato_co_cf, formato_nm_cf, formato_la_cf, formato_im_cf, formato_en_cf, formato_ul_cf, formato_cp_cf, formato_sm_cf, link_sistema_local, link_pacs_local, link_sistema_externo, link_pacs_externo, sitio_web,razon_social_cf, rfc_cf, email_cf, telefono_cf, entidadFederativa_cf, municipio_cf, ciudad_cf, colonia_cf, calle_cf, cp_cf) VALUES ($nombreS, $nombreDB, $nombreM, $precioM, $periodoM, $diasMV, $usuario, $now, $tecla, $formato, $formato1, $formato2, $formato3, $formato4, $formato5, $formato6, $formato7, $link_local_s, $link_local_p, $link_externo_s, $link_externo_p, $sitio_web, $razon_social_cf, $rfc_cf, $email_cf, $telefono_cf, $entidadFederativa_cf, $municipio_cf, $ciudad_cf, $colonia_cf, $calle_cf, $cp_cf)";
   
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
 if(!$update){echo $sql;}else{ echo 1;}

mysql_close($horizonte);
?>
