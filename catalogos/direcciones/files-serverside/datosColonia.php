<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $id = sqlValue($_POST["id_p"], "int");
 
 mysql_select_db($database_horizonte, $horizonte);
 $result = mysql_query("SELECT d_estado,d_municipio,d_asenta,d_codigo, c_oficina, c_municipio,id_mx from mexico where id_mx = $id ", $horizonte) or die (mysql_error());
 $row = mysql_fetch_row($result);

 $datos = $row[0].'*}'. $row[1].'*}'. $row[2].'*}'.$row[3].'*}'. $row[4].'*}'. $row[5].'*}'. $row[6];

 echo $datos;
 
 //Cerrar conexión a la Base de Datos
mysql_close($horizonte);
?>