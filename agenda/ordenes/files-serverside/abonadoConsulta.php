<?php
require("../../../Connections/sigma.php");
require("../../../funciones/php/values.php");
//Generales
 $ref = sqlValue($_POST["ref"], "text");
 
 mysql_select_db($database_sigma, $sigma);
 $resultR = mysql_query("SELECT subtotal_consulta_ov, subtotal_servicios_ov, subtotal_estudios_ov from orden_venta where referencia_ov = $ref ", $sigma) or die (mysql_error());
 $rowR = mysql_fetch_row($resultR);
 
 $subtotales = $rowR[0].";".$rowR[1].";".$rowR[2];
 
 echo $subtotales;
 
 //Cerrar conexión a la Base de Datos
 mysql_close($sigma);
?>