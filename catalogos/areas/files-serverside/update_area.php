<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $id = sqlValue($_POST["idest"], "int");
 $area = sqlValue($_POST["area"], "text");
 $abreviacion = sqlValue($_POST["abreviacion"], "text");
 $idU = sqlValue($_POST["idU"], "int");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");

  
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "UPDATE areas SET nombre_a = $area, clave_a = $abreviacion, usuario_a = $idU, fecha_a = $now WHERE id_a = $id AND departamento_a = 4 limit 1";
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());    
	
 if(!$update){echo $sql;} else{echo 1;}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>