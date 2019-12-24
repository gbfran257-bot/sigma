<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idU = sqlValue($_POST["idU"], "int");
 $input = sqlValue($_POST["input"], "text");
  
 $sql = "UPDATE usuarios SET variable_temporal_u = $input where id_u = $idU limit 1";
 
 mysql_select_db($database_horizonte, $horizonte);
 $insertar = mysql_query($sql, $horizonte) or die (mysql_error());
 	
 if (!$insertar) { echo $sql;}else {echo 1;}
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>