<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $id = sqlValue($_POST["id_um"], "int");
 
 mysql_select_db($database_horizonte, $horizonte);
 $result = mysql_query("SELECT * from medicamentos where id_med = $id ", $horizonte) or die (mysql_error());
 $row = mysql_fetch_row($result);

 $datos = $row[0].'*}'. $row[1].'*}'. $row[2].'*}'. $row[3].'*}'. $row[4].'*}'. $row[5].'*}'. $row[6].'*}'. $row[7].'*}'. $row[8].'*}'. $row[9].'*}'. $row[10].'*}'. $row[11].'*}'. $row[12].'*}'. $row[13].'*}'. $row[14].'*}'. $row[15].'*}'. $row[16].'*}'. $row[17].'*}'. $row[18].'*}'. $row[19].'*}'. $row[20].'*}'. $row[21].'*}'. $row[22] .'*}'. $row[23].'*}'. $row[24];

 echo $datos;
 
 //Cerrar conexión a la Base de Datos
mysql_close($horizonte);
?>