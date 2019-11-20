<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	$idU = sqlValue($_POST["id"], "int");
 	$cActual = $_POST["cA"];
 	$cNueva = sqlValue($_POST["cNueva"], "text");
 
	mysql_select_db($database_horizonte, $horizonte);
	$result = mysql_query("SELECT contrasena_u from usuarios where id_u = $idU ", $horizonte) or die (mysql_error());
	$row = mysql_fetch_row($result);
	
	if($cActual == $row[0]){
		if($cActual != $_POST["cNueva"]){
			mysql_select_db($database_horizonte, $horizonte);
			$sql = "UPDATE usuarios set contrasena_u = $cNueva where id_u = $idU limit 1";
			  
			$update = mysql_query($sql, $horizonte) or die (mysql_error());
				
			if (!$update) { $x1 = $sql; }
			else{ $x1 = 1; }
		}else{$x1 = 'x';}
	
	}else{ $x1 = 0; }

echo $x1;
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>