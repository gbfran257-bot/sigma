<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

//Generales
 $idPaciente = sqlValue($_POST["idPaciente"], "int");
 $now = date('d/m/Y H:i:s');
 
 mysql_select_db($database_horizonte, $horizonte); 
 $resultR = mysql_query("SELECT referencia_ov, DATE_FORMAT(fecha_venta_ov, '%e'), DATE_FORMAT(fecha_venta_ov, '%c'), DATE_FORMAT(fecha_venta_ov, '%Y'), usuario_ov, DATE_FORMAT(fecha_venta_ov, '%H'), DATE_FORMAT(fecha_venta_ov, '%i'), DATE_FORMAT(fecha_venta_ov, '%s') from orden_venta where id_paciente_ov = $idPaciente ORDER BY fecha_venta_ov desc limit 1 ", $horizonte) or die (mysql_error());
 $rowR = mysql_fetch_row($resultR);
 
 mysql_select_db($database_horizonte, $horizonte); 
 $resultRu = mysql_query("SELECT usuario_u from usuarios where id_u = $rowR[4] ", $horizonte) or die (mysql_error());
 $rowRu = mysql_fetch_row($resultRu);
 
 switch($rowR[2]){
	 case 1:
	 	$rowR[2]='ENERO';
	 break;
	 case 2:
	 	$rowR[2]='FEBRERO';
	 break;
	 case 3:
	 	$rowR[2]='MARZO';
	 break;
	 case 4:
	 	$rowR[2]='ABRIL';
	 break;
	 case 5:
	 	$rowR[2]='MAYO';
	 break;
	 case 6:
	 	$rowR[2]='JUNIO';
	 break;
	 case 7:
	 	$rowR[2]='JULIO';
	 break;
	 case 8:
	 	$rowR[2]='AGOSTO';
	 break;
	 case 9:
	 	$rowR[2]='SEPTIEMBRE';
	 break;
	 case 10:
	 	$rowR[2]='OCTUBRE';
	 break;
	 case 11:
	 	$rowR[2]='NOVIEMBRE';
	 break;
	 case 12:
	 	$rowR[2]='DICIEMBRE';
	 break;
 }
 $miFecha = $rowR[1]." DE ".$rowR[2]." DEL ".$rowR[3]." A LAS ".$rowR[5].":".$rowR[6].":".$rowR[7];

 mysql_select_db($database_horizonte, $horizonte); //Si hay Consulta
 $resultC = mysql_query("SELECT COUNT(id_vc), clave_personal_medico_vc from venta_conceptos where referencia_vc = '$rowR[0]' and tipo_concepto_vc = 1 ", $horizonte) or die (mysql_error());
 $rowC = mysql_fetch_row($resultC);
 
 mysql_select_db($database_horizonte, $horizonte); //Datos de la consulta, especialidad 
 $resultCA = mysql_query("SELECT especialidad_u from usuarios where clave_u = '$rowC[1]' ", $horizonte) or die (mysql_error());
 $rowCA = mysql_fetch_row($resultCA);
 
 mysql_select_db($database_horizonte, $horizonte); //Si hay Estudios
 $resultE = mysql_query("SELECT COUNT(id_vc) from venta_conceptos where referencia_vc = '$rowR[0]' and tipo_concepto_vc = 3 ", $horizonte) or die (mysql_error());
 $rowE = mysql_fetch_row($resultE);
 
 mysql_select_db($database_horizonte, $horizonte); //Si hay Servicios
 $resultS = mysql_query("SELECT COUNT(id_vc) from venta_conceptos where referencia_vc = '$rowR[0]' and tipo_concepto_vc = 2 ", $horizonte) or die (mysql_error());
 $rowS = mysql_fetch_row($resultS);
 
 mysql_select_db($database_horizonte, $horizonte); //Adicionales Costos EyS y Totales Generales
 $resultA = mysql_query("SELECT t_urgente_e_ov, t_entrega_domicilio_e_ov, t_toma_domicilio_e_ov, t_urgente_s_ov, t_aDomicilio_s_ov, gran_total_ov, total_real, ahorro, saldo_ov, abonado_ov, total_c from orden_venta where referencia_ov = '$rowR[0]' ", $horizonte) or die (mysql_error());
 $rowA = mysql_fetch_row($resultA);
 $adicionales = $rowA[0].";".$rowA[1].";".$rowA[2].";".$rowA[3].";".$rowA[4].";".$rowA[6].";".$rowA[7].";".$rowA[5].";".$rowA[9].";".$rowA[8];
 
 if($rowCA[0]=='URGENCIAS'){$rowCA[0]='GENERAL';}
 $adicionalesC = $rowCA[0].";".$rowA[10];
 
  mysql_select_db($database_horizonte, $horizonte); 
 $resultP = mysql_query("SELECT nombre_p, apaterno_p, amaterno_p from pacientes where id_p = $idPaciente limit 1 ", $horizonte) or die (mysql_error());
 $rowP = mysql_fetch_row($resultP);
 $nombrePaciente = $rowP[0]." ".$rowP[1]." ".$rowP[2];
 
 $cadena = $rowR[0].";".$miFecha.";".$rowRu[0].";".$nombrePaciente.";".$rowC[0].";".$rowE[0].";".$rowS[0].";".$adicionales.";".$adicionalesC.";".$now;
 echo $cadena;
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>