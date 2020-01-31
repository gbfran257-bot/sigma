<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $id_consulta = sqlValue($_POST["id_vc"], "int");
  
 mysql_select_db($database_horizonte, $horizonte); 
 $result1= mysql_query("SELECT count(id_h) from hospitalizacion where id_consulta_vc_h = $id_consulta", $horizonte) or die (mysql_error());
 $row1 = mysql_fetch_row($result1);
 
 echo $row1[0];
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>