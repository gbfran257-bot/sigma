<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $clv_carrera = sqlValue($_POST["clv_carrera"], "int");
 $nombre = sqlValue(mb_strtoupper($_POST["nombre_carrera"]), "text");
//  $abreviacion = sqlValue($_POST["abreviacion_u"], "text");
//  $now = sqlValue(date('Y-m-d H:i:s'), "date");
  
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO profesiones(clave_profesion_p, nombre_profesion)";
 $sql.= "VALUES ($clv_carrera,$nombre)";
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
 if(!$update){echo $sql;} else{echo 1;}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>