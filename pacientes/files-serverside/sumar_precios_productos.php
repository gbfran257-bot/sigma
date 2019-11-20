<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $aleatorio = sqlValue($_POST["aleatorio"], "text");
 mysql_select_db($database_horizonte, $horizonte); 
 $result = mysql_query("SELECT sum(v.precio_vc) from venta_conceptos v left join conceptos e on e.id_to = v.id_concepto_es where v.no_temp_vc = $aleatorio and e.id_tipo_concepto_to = 5", $horizonte) or die (mysql_error());
 $row = mysql_fetch_row($result);
 
 echo $row[0];
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>