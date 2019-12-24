<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idE = sqlValue($_POST["idE"], "int");
 
mysql_select_db($database_horizonte, $horizonte);
  
	$result = mysql_query("SELECT observaciones_vc, id_paciente_vc from venta_conceptos where id_vc = $idE limit 1", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result);
	
	$result1 = mysql_query("SELECT nombre_p, apaterno_p, amaterno_p from pacientes where id_p = $row[1] limit 1", $horizonte) or die (mysql_error());
 	$row1 = mysql_fetch_row($result1);
	
	$paciente = $row1[0].' '.$row1[1].' '.$row1[2];
	
	$resultK = mysql_query("SELECT imagen_ie from img_consulta where id_estudio_vc_ie = $idE order by id_ie desc limit 1", $horizonte) or die (mysql_error());
 	$rowK = mysql_fetch_row($resultK); if ($rowK[0]==''){$rowK[0]=0;}
	
	$resultP = mysql_query("SELECT count(id_h) from hospitalizacion where id_consulta_vc_h = $idE and fecha_fin_h IS NULL", $horizonte) or die (mysql_error());
 	$rowP = mysql_fetch_row($resultP);
  
echo 'PACIENTE: '.$paciente.'*[+'.$rowK[0].'*[+'.$rowP[0];

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>