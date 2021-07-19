<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $idU = sqlValue($_POST["idUser_met"], "int");
 $idM = sqlValue($_POST["idMetodo"], "int");
 $nombre = sqlValue(mb_strtoupper($_POST["nombre_metodo"]), "text");
//  $abreviacion = sqlValue($_POST["abreviacion_u"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
  
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "UPDATE metodos set metodo_me = $nombre, usuario_reg_me = $idU, fecha_reg_me = $now where id_me = $idM limit 1";
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());    
	
 if(!$update){echo $sql;} else{echo 1;}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>