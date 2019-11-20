<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $id = sqlValue($_POST["id"], "int");
 $que = sqlValue($_POST["que"], "int");
 $quien = sqlValue($_POST["quien"], "int");
 $titulo = sqlValue(mb_strtoupper($_POST["titulo"]), "text");
 $start = sqlValue($_POST["start"], "date");
 $end = sqlValue($_POST["end"], "date");
 $descripcion = sqlValue(mb_strtoupper($_POST["descripcion"]), "text");
 $id_user_r = sqlValue($_POST["id_user_r"], "int");
 $estatus = sqlValue($_POST["estatus"], "text"); 
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 
 mysql_select_db($database_horizonte, $horizonte);
 if($_POST["estatus"]=='PENDIENTE'){
	 $color = sqlValue('gray', "text");
	 $sql = "UPDATE events set title = $titulo, color = $color, description = $descripcion, estatus = $estatus where id = $id limit 1";
 }else if($_POST["estatus"]=='CONFIRMADO'){
	 $color = sqlValue('green', "text");
	 $sql = "UPDATE events set title = $titulo, color = $color, description = $descripcion, estatus = $estatus, id_u_confirma = $id_user_r, fecha_confirma = $now where id = $id limit 1";
 }else if($_POST["estatus"]=='CANCELADO'){
 	 $color = sqlValue('red', "text");
	 $sql = "UPDATE events set title = $titulo, color = $color, description = $descripcion, estatus = $estatus, id_u_cancela = $id_user_r, fecha_cancela = $now where id = $id limit 1";
 }
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
 if(!$update){echo $sql;}
 else{ echo '1'.';'.$color; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>