<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idP = sqlValue($_POST["idP"], "int");
 $idU = sqlValue($_POST["idU"], "int");
 $idC = sqlValue($_POST["idC"], "int");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 $st = sqlValue($_POST["st"], "int");
 
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "UPDATE venta_conceptos SET estatus_vc = $st, usuarioEdo2_e = $idU, fechaEdo2_e = $now where id_vc = $idC limit 1";
 
 mysql_select_db($database_horizonte, $horizonte); 
 $resultC=mysql_query("SELECT DATE_FORMAT(v.fecha_venta_vc,'%d/%c/%Y'), v.motivo_visita_vc, v.no_temp_vc from venta_conceptos v where v.id_vc = $idC",$horizonte) or die (mysql_error());
 $rowC = mysql_fetch_row($resultC);
 
 mysql_select_db($database_horizonte, $horizonte); 
 $resultS = mysql_query("SELECT DATE_FORMAT(fecha_sv,'%d/%c/%Y %H:%i:%s'), id_usuario_sv, oximetria_sv, a_ocular_sv, r_verbal, r_motriz from signos_vitales where id_paciente_sv = $idP order by id_sv desc limit 1", $horizonte) or die (mysql_error());
 $rowS = mysql_fetch_row($resultS); $us_sv = sqlValue($rowS[1], "int");
 
 mysql_select_db($database_horizonte, $horizonte); 
 $resultUs = mysql_query("SELECT usuario_u from usuarios where id_u = $us_sv", $horizonte) or die (mysql_error());
 $rowUs = mysql_fetch_row($resultUs);
 
 mysql_select_db($database_horizonte, $horizonte); 
 $resultPa = mysql_query("SELECT nombre_p, apaterno_p, amaterno_p from pacientes where id_p = $idP", $horizonte) or die (mysql_error());
 $rowPa = mysql_fetch_row($resultPa);
 $nombreP = $rowPa[0].' '.$rowPa[1].' '.$rowPa[2];
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) { echo $sql; }else { echo "1".";*-".$rowC[0].";*-".$rowS[0].";*-".$rowC[1].";*-".$rowC[2].";*-".$nombreP.";*-".$rowUs[0].";*-".$rowS[2].";*-".$rowS[3].";*-".$rowS[4].";*-".$rowS[5]; }
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>