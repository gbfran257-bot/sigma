<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $id_f = sqlValue($_POST["id_f"], "int");

//  $now = sqlValue(date('Y-m-d H:i:s'), "date");
  
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "DELETE FROM formatos WHERE id_fo = $id_f LIMIT 1";
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
 if(!$update){echo $sql;} else{echo 1;}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>