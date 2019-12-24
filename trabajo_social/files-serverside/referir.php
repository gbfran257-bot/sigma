<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idU = sqlValue($_POST["idUESE1"], "int");
 $idR = sqlValue($_POST["idRESE1"], "int");
 $motivo = sqlValue($_POST["motivo_referido"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "UPDATE rehabilitacion SET estatus_t = 12, motivo_declinado_t = $motivo, usuario_declinado_t = $idU, fecha_declinado_t = $now where id_t = $idR limit 1";
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
 if (!$update) { echo $sql; }else { echo 1; }
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>