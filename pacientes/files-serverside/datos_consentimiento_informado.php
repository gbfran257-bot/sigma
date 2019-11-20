<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idP = sqlValue($_POST["idP"], "int");
 $nowD = date('d');
 switch(date('m')){
	 case '01': $nowM = 'ENERO'; break;
	 case '02': $nowM = 'FEBRERO'; break;
	 case '03': $nowM = 'MARZO'; break;
	 case '04': $nowM = 'ABRIL'; break;
	 case '05': $nowM = 'MAYO'; break;
	 case '06': $nowM = 'JUNIO'; break;
	 case '07': $nowM = 'JULIO'; break;
	 case '08': $nowM = 'AGOSTO'; break;
	 case '09': $nowM = 'SEPTIEMBRE'; break;
	 case '10': $nowM = 'OCTUBRE'; break;
	 case '11': $nowM = 'NOVIEMBRE'; break;
	 case '12': $nowM = 'DICIEMBRE'; break;
	 default: $nowM = 'ERROR';
 }
 $nowA = date('Y');
 $nowH = date('H:i');
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 
 mysql_select_db($database_horizonte, $horizonte); 
 $resultP = mysql_query("SELECT nombre_completo_p from pacientes where id_p = $idP", $horizonte) or die (mysql_error());
 $rowP = mysql_fetch_row($resultP);
		
echo $nowD.';[*'.$nowM.';[*'.$nowA.';[*'.$nowH.';[*'.$rowP[0].';[*';

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>