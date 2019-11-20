<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

include_once '../../recursos/session.php';
include_once '../../Connections/database.php';
include_once '../../recursos/utilities.php';

 $idU = sqlValue($_POST["id_u"], "int"); $tempN = sqlValue($_POST["tempo"], "text");
 $id_us = $_SESSION['id']; $now = sqlValue(date('Y-m-d H:i:s'), "date");
 
 	mysql_select_db($database_horizonte, $horizonte);
 	$result = mysql_query("SELECT u.nombre_u, u.apaterno_u, u.amaterno_u, u.cedulaProfesionalE_u, u.especialidad_u, u.cedulaProfesional_u, u.curp_u, u.tCelular_u, u.tParticular_u, u.tTrabajo_u, u.extensionTt_u, u.tEmergencia_u, u.contactoEmergencia_u, u.rfc_u, u.idSucursal_u, u.email_u, u.sexo_u, DATE_FORMAT(u.fNac_u,'%d/%c/%Y'), u.notas_u, u.idEscolaridad_u, u.usuario_u, u.acceso_u, u.idDepartamento_u, u.idProfesion_u, u.nacionalidad_u, u.idPuesto_u, u.cedulaProfesionalE_u, u.calle_u, u.entidadFederativa_u, u.municipio_u, u.colonia_u, u.cp_u, u.tSanguineo_u, u.id_titulo_u, X(GeomFromText(AsText(u.coordenadas_u))), Y(GeomFromText(AsText(u.coordenadas_u))), u.horario_e_lu, u.horario_s_lu, u.horario_e_ma, u.horario_s_ma, u.horario_e_mi, u.horario_s_mi, u.horario_e_ju, u.horario_s_ju, u.horario_e_vi, u.horario_s_vi, u.horario_e_sa, u.horario_s_sa, u.horario_e_do, u.horario_s_do, u.temporal_u, u.universidad_u, u.estatus_laboral_u, multisucursal_u, u.estatus_escolar_u, u.permisos_u, u.universidad_e_u from usuarios u where id_u = $idU limit 1 ", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result); $idSu = sqlValue($row[14], "int");
	
	mysql_select_db($database_horizonte, $horizonte);
 	$resultS=mysql_query("SELECT count(id_su) from sucursales_usuarios where id_usuario_su = $idU",$horizonte) or die (mysql_error());
 	$rowS = mysql_fetch_row($resultS);
	
	if($row[50]==NULL or $row[50]=='NULL' or $row[50]==''){
		$row[50] = $_POST["tempo"]; $temp_u = sqlValue($_POST["tempo"], "text");
		
		$sqlUU = "UPDATE usuarios SET temporal_u = $temp_u where id_u = $idU limit 1";
  	    mysql_select_db($database_horizonte, $horizonte); $insertarUU = mysql_query($sqlUU, $horizonte) or die (mysql_error());
		
		if($rowS[0]<1){//No tiene ninguna sucursal asignada
			mysql_select_db($database_horizonte, $horizonte);
			$sqlS = "INSERT INTO sucursales_usuarios(id_sucursal_su, id_usuario_su, usuario_su, fecha_su, primaria_su, aleatorio_su) VALUES($idSu, $idU, $id_us, $now, 1, $temp_u)"; //echo $sqlS;
			$insertS = mysql_query($sqlS, $horizonte) or die (mysql_error());
		}else{}
	}else{ 
		$temp_u = sqlValue($row[50], "text"); 
		if($rowS[0]<1){//No tiene ninguna sucursal asignada
			mysql_select_db($database_horizonte, $horizonte);
			$sqlS = "INSERT INTO sucursales_usuarios(id_sucursal_su, id_usuario_su, usuario_su, fecha_su, primaria_su, aleatorio_su) VALUES($idSu, $idU, $id_us, $now, 1, $temp_u)"; //echo $sqlS;
			$insertS = mysql_query($sqlS, $horizonte) or die (mysql_error());
		}else{}
	}
	
 	$datos = $row[0].";-}{".$row[1].";-}{".$row[2].";-}{".$row[3].";-}{".$row[4].";-}{".$row[5].";-}{".$row[6].";-}{".$row[7].";-}{".$row[8].";-}{".$row[9].";-}{".$row[10].";-}{".$row[11].";-}{".$row[12].";-}{".$row[13].";-}{".$row[14].";-}{".$row[15].";-}{".$row[16].";-}{".$row[17].";-}{".$row[18].";-}{".$row[19].";-}{".$row[20].";-}{".$row[21].";-}{".$row[22].";-}{".$row[23].";-}{".$row[24].";-}{".$row[25].";-}{".$row[26].";-}{".$row[27].";-}{".$row[28].";-}{".$row[29].";-}{".$row[30].";-}{".$row[31].";-}{".$row[32].";-}{".$row[33].";-}{".$row[34].";-}{".$row[35].";-}{".$row[36].";-}{".$row[37].";-}{".$row[38].";-}{".$row[39].";-}{".$row[40].";-}{".$row[41].";-}{".$row[42].";-}{".$row[43].";-}{".$row[44].";-}{".$row[45].";-}{".$row[46].";-}{".$row[47].";-}{".$row[48].";-}{".$row[49].";-}{".$row[50].";-}{".$row[51].";-}{".$row[52].";-}{".$row[53].";-}{".$row[54].";-}{".$row[55].";-}{".$row[56];

echo $datos;
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>