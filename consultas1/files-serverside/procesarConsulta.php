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
 $resultC = mysql_query("SELECT DATE_FORMAT(fecha_venta_vc,'%d/%c/%Y'), motivo_visita_vc, no_temp_vc from venta_conceptos where id_vc = $idC and tipo_concepto_vc = 1", $horizonte) or die (mysql_error());
 $rowC = mysql_fetch_row($resultC);
 
 mysql_select_db($database_horizonte, $horizonte); 
 $resultS = mysql_query("SELECT DATE_FORMAT(fecha_sv,'%d/%c/%Y') from signos_vitales where id_paciente_sv = $idP order by id_sv desc limit 1", $horizonte) or die (mysql_error());
 $rowS = mysql_fetch_row($resultS);
 
 mysql_select_db($database_horizonte, $horizonte); 
 $resultPa = mysql_query("SELECT nombre_p, apaterno_p, amaterno_p from pacientes where id_p = $idP", $horizonte) or die (mysql_error());
 $rowPa = mysql_fetch_row($resultPa);
 $nombreP = $rowPa[0].' '.$rowPa[1].' '.$rowPa[2];
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) { echo $sql; }else { echo "1".";*-".$rowC[0].";*-".$rowS[0].";*-".$rowC[1].";*-".$rowC[2].";*-".$nombreP; }
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>