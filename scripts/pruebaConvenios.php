<?php
require("../Connections/horizonte.php");
require("../funciones/php/values.php");
/*
mysql_select_db($database_horizonte, $horizonte);
		$consulta = "SELECT id_p from pacientes ";
		$query = mysql_query($consulta) or die (mysql_error());
		while ($fila = mysql_fetch_array($query)) {
			mysql_select_db($database_horizonte, $horizonte);
			 $miidP = $fila['id_p'];
			 $sql = "INSERT INTO convenios_paciente (id_paciente_cvp, id_convenio_cvp, fecha_expedicion_cvp, fecha_expiracion_cvp, usuario_cvp, fecha_cvp)";
			 $sql.= "VALUES ($miidP, 1, now(), '3000-01-01', 1, now() )";
			  
			 $update = mysql_query($sql, $horizonte) or die (mysql_error());
		};	
	*/
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>