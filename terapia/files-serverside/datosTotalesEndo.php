<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $noAleatorio = sqlValue($_POST["noAleatorio"], "text");
 
 	mysql_select_db($database_horizonte, $horizonte); 
 	$resultC = mysql_query("SELECT sum(precio_normal_vc) from venta_conceptos where no_temp_vc = $noAleatorio and departamento_vc = 15", $horizonte) or die (mysql_error());
	$rowC = mysql_fetch_row($resultC);
		
	echo $rowC[0];

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>