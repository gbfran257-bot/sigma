<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $id = sqlValue($_POST["idPaciente"], "int");
 
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "DELETE from pacientes where id_p = $id limit 1";
  
$update = mysql_query($sql, $horizonte);
	
if (!$update) {
 	echo $sql;
 }else{ 
	mysql_select_db($database_horizonte, $horizonte);
 	$sql1 = "DELETE from historia_clinica where id_paciente_hc = $id limit 1";
  
	$update1 = mysql_query($sql1, $horizonte);
	if (!$update1) {
 		echo $sql1;
 	}else{ echo "ok"; }
 
 }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>