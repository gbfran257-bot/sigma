<?php
require("../Connections/horizonte.php");
require("../funciones/php/values.php");

 $id = sqlValue($_POST["id"], "int");

//  $now = sqlValue(date('Y-m-d H:i:s'), "date");
  
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "DELETE FROM muestras WHERE id_mu = $id";
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
 if(!$update){echo $sql;} else{echo 1;}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>