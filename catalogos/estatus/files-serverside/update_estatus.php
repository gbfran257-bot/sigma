<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $id = sqlValue($_POST["idest"], "int");
 $estatus = sqlValue($_POST["col_est"], "text");

  
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "UPDATE estatus set estatus_est = $estatus where id_est = $id limit 1";
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());    
	
 if(!$update){echo $sql;} else{echo 1;}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>