<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $id_f = sqlValue($_POST["id_f"], "int");

 mysql_select_db($database_horizonte, $horizonte);
 $resultR2 = mysql_query("SELECT formato_fo from formatos where id_fo = $id_f", $horizonte);
 $rowR2 = mysql_fetch_row($resultR2);

 echo $rowR2[0];

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>