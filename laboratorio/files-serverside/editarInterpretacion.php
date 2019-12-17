<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idE = sqlValue($_POST["idE"], "int");
 $idU = sqlValue($_POST["idU"], "int");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "UPDATE venta_conceptos SET estatus_vc = 4 where id_vc = $idE limit 1";
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
 if(!$update){ echo $sql; }else{ echo 1; }
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>