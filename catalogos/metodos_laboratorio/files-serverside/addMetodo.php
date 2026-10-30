<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

$idU = sqlValue($_POST["idUser_met"], "int");
 $nombre = sqlValue(mb_strtoupper($_POST["nombre_metodo"]), "text");
//  $idU = sqlValue(mb_strtoupper($_POST["idUser_met"]), "int");
//  $abreviacion = sqlValue($_POST["abreviacion_u"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
  
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO metodos(metodo_me, usuario_reg_me, fecha_reg_me)";
 $sql.= "VALUES ($nombre,$idU,$now)";
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
 if(!$update){echo $sql;} else{echo 1;}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>