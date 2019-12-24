<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idM = sqlValue($_POST["idM"], "int");
 $indiM = sqlValue($_POST["indiM"], "text");
 
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "UPDATE medicamentos_hospital SET indicacion_mh = $indiM where id_mh = $idM limit 1";
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
 if (!$update) { echo $sql; }else { echo 1; }
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>