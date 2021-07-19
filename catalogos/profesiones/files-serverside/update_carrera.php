<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $clv = sqlValue($_POST["clv_carrera"], "int");
 $idP = sqlValue($_POST["idProfesion"], "int");
 $nombre = sqlValue(mb_strtoupper($_POST["nombre_carrera"]), "text");
//  $abreviacion = sqlValue($_POST["abreviacion_u"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
  
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "UPDATE profesiones set nombre_profesion = $nombre, clave_profesion_p = $clv where id_profesion = $idP limit 1";
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());    
	
 if(!$update){echo $sql;} else{echo 1;}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>