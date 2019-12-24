<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");
//Generales
 $noRef = sqlValue($_POST["id"], "int");
 
 mysql_select_db($database_horizonte, $horizonte);
 $resultHl = mysql_query("SELECT muestras_ov from orden_venta where id_ov = $noRef limit 1;",$horizonte) or die (mysql_error());
 $rowHl = mysql_fetch_row($resultHl);
 
 echo $rowHl[0];
	
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>