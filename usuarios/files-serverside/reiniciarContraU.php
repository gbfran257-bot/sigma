<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idUs = sqlValue($_POST["idUs"], "int"); //usuario a reiniciar
 $idU = sqlValue($_POST["idU"], "int");
 $user = sqlValue($_POST["user"], "text");
 $opc = sqlValue($_POST["opc"], "int");
 
 if($opc==1){
 	mysql_select_db($database_horizonte, $horizonte);
 	$sql = "UPDATE usuarios SET activo_u = 0 where id_u = $idUs limit 1";
 }
 else{
	mysql_select_db($database_horizonte, $horizonte);
 	$sql = "UPDATE usuarios SET activo_u = 1 where id_u = $idUs limit 1";
 }
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) { echo $sql; }else { echo 1; }
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>