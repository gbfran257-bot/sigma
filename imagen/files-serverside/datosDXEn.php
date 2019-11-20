<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idE = sqlValue($_POST["idE"], "int");
 
mysql_select_db($database_horizonte, $horizonte);
  
	$result = mysql_query("SELECT referencia_vc, id_paciente_vc from venta_conceptos where id_vc = $idE limit 1", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result); $refe = sqlValue($row[0], "text");
	
	$result1 = mysql_query("SELECT nombre_p, apaterno_p, amaterno_p from pacientes where id_p = $row[1] limit 1", $horizonte) or die (mysql_error());
 	$row1 = mysql_fetch_row($result1);
	
	$paciente = $row1[0].' '.$row1[1].' '.$row1[2];
	
	$resultK=mysql_query("SELECT imagen_ie from img_endoscopia where id_estudio_vc_ie = $idE order by id_ie desc limit 1", $horizonte) or die (mysql_error());
 	$rowK = mysql_fetch_row($resultK); if ($rowK[0]==''){$rowK[0]=0;}
	
	$resultD = mysql_query("SELECT observaciones_i_ov from orden_venta where referencia_ov = $refe limit 1", $horizonte) or die (mysql_error());
 	$rowD = mysql_fetch_row($resultD);
  
echo 'PACIENTE: '.$paciente.'. DX DE ENVÍO: '.$rowD[0].'*[+'.$rowK[0];

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>