<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $aleatorio = sqlValue($_POST["aleatorio"], "text");
 mysql_select_db($database_horizonte, $horizonte); 
 $result = mysql_query("SELECT SUM(vc.descuento) FROM   venta_conceptos vc left join conceptos e on e.id_to = vc.id_concepto_es left join areas a on a.id_a = e.id_area_to left join convenios c on c.id_cv = vc.id_convenio_vc WHERE vc.no_temp_vc = $aleatorio and e.id_tipo_concepto_to = 3", $horizonte) or die (mysql_error());
 $row = mysql_fetch_row($result);
 
 echo $row[0];
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>