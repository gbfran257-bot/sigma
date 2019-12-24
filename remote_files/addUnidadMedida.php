<?php
require("../Connections/horizonte.php");
require("../funciones/php/values.php");

 $idU = sqlValue($_POST["id_usr_reg"], "int");
 $nombre = sqlValue(mb_strtoupper($_POST["unidad_m"]), "text");
 $abreviacion = sqlValue($_POST["abreviacion_u"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
  
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO unidades(unidad_un, abreviacion_un, usuario_un, fecha_un)";
 $sql.= "VALUES ($nombre, $abreviacion, $idU, $now)";
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
 if(!$update){echo $sql;} else{echo 1;}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>