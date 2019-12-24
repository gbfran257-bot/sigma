<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idP = sqlValue($_POST["idPESE"], "int");
 $idU = sqlValue($_POST["idUESE"], "int");
 $idR = sqlValue($_POST["idRESE"], "int");
 $diagnostico = sqlValue($_POST["dxNS"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "UPDATE rehabilitacion SET estatus_t = 2, nivel_se_t = $diagnostico where id_t = $idR limit 1";
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
 if (!$update) { echo $sql; }else { echo 1; }
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>