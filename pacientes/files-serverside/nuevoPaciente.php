<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idUsuario = sqlValue($_POST["misDatos"], "int");

 mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO pacientes (usuario_pa, fecha_temporal_pa)";
 $sql.= "VALUES ($idUsuario, now())";
  
$update = mysql_query($sql, $horizonte);
	
if (!$update) { echo 'bad'; }
 else{ 
 	mysql_select_db($database_horizonte, $horizonte);
 	$result = mysql_query("SELECT id_p from pacientes order by id_p desc limit 1 ", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result);
	
	mysql_select_db($database_horizonte, $horizonte);
 	$sql1 = "INSERT INTO historia_clinica (id_paciente_hc, id_usuario_hc, fecha_temporal_hc)";
 	$sql1.= "VALUES ($row[0], $idUsuario, now())";
  
	$update1 = mysql_query($sql1, $horizonte);
	
	if (!$update1) {
 		echo $update1;
 	}else{echo $row[0];}

 }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>