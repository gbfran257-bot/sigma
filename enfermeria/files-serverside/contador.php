<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $time = $_POST["time"];
 
 $fecha1 = new DateTime($time); $fecha2 = new DateTime(date("Y-m-d H:i:s")); $fecha = $fecha1->diff($fecha2);
 $anos=$fecha->y; $meses=$fecha->m; $dias=$fecha->d; $horas=$fecha->h; $minutos=$fecha->i; $segundos=$fecha->s;
 $miTime = sprintf("%02d", $dias)."D/".sprintf("%02d", $horas).":".sprintf("%02d", $minutos).":".sprintf("%02d", $segundos); 
		  	
 echo $miTime;

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>