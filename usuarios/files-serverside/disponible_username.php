<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $username = sqlValue($_GET['username'], "text");
 $id_user_update = sqlValue($_GET["id_user_update"], "int");
 
 mysql_select_db($database_horizonte, $horizonte);
 
 if(isset($_GET["id_user_update"])){
 	$result = mysql_query("SELECT count(id_u) FROM usuarios where usuario_u = $username and id_u != $id_user_update", $horizonte) or die(mysql_error());
 }else{
 	$result = mysql_query("SELECT count(id_u) FROM usuarios where usuario_u = $username", $horizonte) or die(mysql_error());
 }
 
 $row = mysql_fetch_row($result);
 	
if($row[0]>0){ http_response_code(418); }//si nadie lo tiene
else{ http_response_code(200); } //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>