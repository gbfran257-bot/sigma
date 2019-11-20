<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $refe = sqlValue($_POST["refe"], "text");
 
 mysql_select_db($database_horizonte, $horizonte); 
 $sql = "delete from venta_conceptos where referencia_vc = $refe";
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
 if (!$update){ echo $sql; }
 else{
	 mysql_select_db($database_horizonte, $horizonte); 
	 $sql1 = "delete from pagos_ov where referencia_pag = $refe";
	 $update1 = mysql_query($sql1, $horizonte) or die (mysql_error());
	 
	 if (!$update1){ echo $sql1; }
 	 else{
		 mysql_select_db($database_horizonte, $horizonte); 
		 $sql2 = "delete from orden_venta where referencia_ov = $refe limit 1";
		 $update2 = mysql_query($sql2, $horizonte) or die (mysql_error());
		 
		 if (!$update2){ echo $sql2; }
 	 	else{
	 		echo 1;
		}
	 }
 }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>