<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $id = sqlValue($_POST["id"], "int");
 $mensaje = sqlValue($_POST["mensaje"], "text");
  
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "UPDATE mensaje_nom35 SET mensaje_mn = $mensaje WHERE id_mn = $id";
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());    
	
 if(!$update){echo $sql;} else{echo 1;}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>