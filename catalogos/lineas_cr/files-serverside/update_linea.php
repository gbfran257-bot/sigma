<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $id = sqlValue($_POST["idest"], "int");
 $linea = sqlValue($_POST["linea"], "text");
 $descripcion = sqlValue($_POST["descripcion"], "text");
 $idU = sqlValue($_POST["idU"], "int");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");

  
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "UPDATE catalogo_lineas_cr set nombre_l = $linea, descripcion_l = $descripcion, usuario_l = $idU, fecha_l = $now where id_l = $id limit 1";
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());    
	
 if(!$update){echo $sql;} else{echo 1;}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>