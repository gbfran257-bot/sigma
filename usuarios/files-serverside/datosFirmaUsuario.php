<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	$idU = sqlValue($_POST["idU"], "int");
 	$titulo = sqlValue($_POST["titulo"], "text");
 	$cedula = sqlValue($_POST["cedula"], "text");
 
	mysql_select_db($database_horizonte, $horizonte);
	$sql = "UPDATE usuarios set cedulaProfesional_u = $cedula, titulo_u = $titulo where id_u = $idU limit 1";
	  
	$update = mysql_query($sql, $horizonte) or die (mysql_error());
		
	if (!$update) { echo $sql; }else{ echo 1;}
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>