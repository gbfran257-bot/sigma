<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

//datos generales
 $idDC = sqlValue($_POST["dc"], "int");
 
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "delete from convenios_paciente where id_cvp = $idDC limit 1";
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
 if (!$update) {echo $sql;}
 else{ 
	
 	 mysql_select_db($database_horizonte, $horizonte);
	 $sql1 = "delete from conceptos_beneficios where id_convenio_paciente_cb = $idDC";
	 $update1 = mysql_query($sql1, $horizonte) or die (mysql_error());
		
	 if (!$update1) {echo $sql1;}
	 else{ 
		echo 1;
	 }
 }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>