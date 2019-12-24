<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idC = sqlValue($_POST["idC"], "int");
 $estatusC = sqlValue($_POST["estatusC"], "text");
 $referenciaC = sqlValue($_POST["referenciaC"], "text");
 if($_POST["estatusC"] == "PENDIENTE"){
	 $estatusC = sqlValue("PROCESO", "text");
 }

 mysql_select_db($database_horizonte, $horizonte);
 $sql = "UPDATE consultas SET estatus_con = $estatusC where id_con = $idC ";
  
$update = mysql_query($sql, $horizonte);
	
if (!$update) {
 	echo $sql;
 }else{ 
	echo "ok";
 }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>