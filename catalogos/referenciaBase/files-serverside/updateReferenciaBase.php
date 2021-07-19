<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $idU = sqlValue($_POST["id_usr_update"], "int");
 $idRef = sqlValue($_POST["id_unidad_m"], "int");
 $nombre = sqlValue(mb_strtoupper($_POST["tipo_ref"]), "text");
//  $abreviacion = sqlValue($_POST["abreviacion_u"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
  
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "UPDATE catalogo_valores_referencia set tipo_cvr = $nombre, usuario_cvr = $idU, fecha_cvr = $now where id_cvr = $idRef limit 1";
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());    
	
 if(!$update){echo $sql;} else{echo 1;}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>