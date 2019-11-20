<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");
//Generales
 $ref = sqlValue($_POST["ref"], "text");
 
 mysql_select_db($database_horizonte, $horizonte);
 $resultR = mysql_query("SELECT count(id_vc) from venta_conceptos where referencia_vc = $ref and tipo_concepto_vc = 3 ", $horizonte) or die (mysql_error());
 $rowR = mysql_fetch_row($resultR);
  
 $subtotales = $rowR[0];
 echo $subtotales;
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>