<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idP = sqlValue($_POST["idP"], "int"); $tempN = sqlValue($_POST["tempN"], "text"); 
 
 	mysql_select_db($database_horizonte, $horizonte);
 	$result = mysql_query("SELECT curp_p, nombre_p, apaterno_p, amaterno_p, nSocioeconomico_p, tVivienda_p, tSanguineo_p, idDiscapacidad_p, grupoEtnico_p, idReligion_p, tCelular_p, tParticular_p, tTrabajo_p, extensionTt_p, rfc_p, contactoEmergencia_p, tEmergencia_p, idSucursal_p, email_p, sexo_p, DATE_FORMAT(fNac_p,'%d/%c/%Y'), notas_p, escolaridad_p, idOcupacion_p, nacionalidad_p, calle_p, id_p, id_p, entidadFederativa_p, municipio_p, colonia_p, cp_p, id_p, idUsuarioR_p, fechaR_p, id_p, fNac_p, id_p, id_p, id_p, idUsuarioR_p, DATE_FORMAT(fechaR_p,'%d/%c/%Y %H:%m'), entidad_nacimiento_p, razon_social_p, calle_pf, cp_pf, id_p, entidadFederativa_pf, municipio_pf, colonia_pf, cp_pf, rfc_f_p, id_p, id_p, centro_salud_p, derechohabiencia_p, X(GeomFromText(AsText(coordenadas_p))), Y(GeomFromText(AsText(coordenadas_p))), no_seguridad_social_p, ciudad_p, email_pf, ciudad_pf, facebook, instagram, regimen_fiscal, uso_cfdi, facturar, proveedor, puesto_p, parentesco, clave_t, tipo_trabajador, departamento, tarjeton from pacientes where id_p = $idP ", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result);
	
	/*if($row[38]==NULL or $row[38]=='NULL'){
		$row[38] = $_POST["tempN"];
		$temp_u = sqlValue($row[38], "text");
		
		$sqlUU = "UPDATE pacientes SET temporal_p = $temp_u where id_p = $idP limit 1";
  	    mysql_select_db($database_horizonte, $horizonte); $insertarUU = mysql_query($sqlUU, $horizonte) or die (mysql_error());
	}else{ $temp_u = sqlValue($row[38], "text"); }
	
	mysql_select_db($database_horizonte, $horizonte);
 	$resultEx1 = mysql_query("SELECT ext_do from documentos where nombre_do = $temp_u and que_es_do = 'FOTO' ", $horizonte) or die (mysql_error());
 	$rowEx1 = mysql_fetch_row($resultEx1);*/
	
	mysql_select_db($database_horizonte, $horizonte);$idO = sqlValue($row[23], "int");
 	$result1 = mysql_query("SELECT ocupacion from catalogo_ocupaciones where id_ocupacion = $idO ", $horizonte) or die (mysql_error());
 	$row1 = mysql_fetch_row($result1);
	
	mysql_select_db($database_horizonte, $horizonte);$idU = sqlValue($row[40], "int");
 	$result2 = mysql_query("SELECT usuario_u from usuarios where id_u = $idU ", $horizonte) or die (mysql_error());
 	$row2 = mysql_fetch_row($result2);
		 
 	$datos = $row[0]."*}".$row[1]."*}".$row[2]."*}".$row[3]."*}".$row[4]."*}".$row[5]."*}".$row[6]."*}".$row[7]."*}".$row[8]."*}".$row[9]."*}".$row[10]."*}".$row[11]."*}".$row[12]."*}".$row[13]."*}".$row[14]."*}".$row[15]."*}".$row[16]."*}".$row[17]."*}".$row[18]."*}".$row[19]."*}".$row[20]."*}".$row[21]."*}".$row[22]."*}".$row1[0]."*}".$row[24]."*}".$row[25]."*}".$row[26]."*}".$row[27]."*}".$row[28]."*}".$row[29]."*}".$row[30]."*}".$row[31]."*}".$row[32]."*}".$row[33]."*}".$row[34]."*}".$row[35]."*}".$row[36]."*}".$row[37]."*}".$row[38]."*}".$row[39]."*}".$row2[0]."*}".$row[41]."*}".$row[42]."*}".$row[43]."*}".$row[44]."*}".$row[45]."*}".$row[46]."*}".$row[47]."*}".$row[48]."*}".$row[49]."*}".$row[50]."*}".$row[51]."*}".$row[52]."*}".$row[53]."*}".$row[54]."*}".$row[55]."*}".$row[56]."*}".$row[57]."*}".$rowEx1[0]."*}".$row[58]."*}".$row[59]."*}".$row[60]."*}".$row[61]."*}".$row[62]."*}".$row[63]."*}".$row[64]."*}".$row[65]."*}".$row[66]."*}".$row[67]."*}".$row[68]."*}".$row[69] . "*}" . $row[70] . "*}" . $row[71] . "*}" . $row[72] . "*}" . $row[73] . "*}" . $row[74] . "*}" . $row[75];

echo $datos;
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>