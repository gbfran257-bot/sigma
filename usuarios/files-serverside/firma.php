<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	$id = sqlValue($_POST["id"], "int");
	$tempo = sqlValue($_POST["tempo"], "text");
 
 	mysql_select_db($database_horizonte, $horizonte);
 	$sql1 = "UPDATE documentos set firma_do = 0 where aleatorio_do = $tempo;";
	$update1 = mysql_query($sql1, $horizonte) or die (mysql_error());
	
	if(!$update1){echo $sql1; }else{
		mysql_select_db($database_horizonte, $horizonte);
		$sql = "UPDATE documentos set firma_do = 1 where id_do = $id limit 1;";
		$update = mysql_query($sql, $horizonte) or die (mysql_error());
		
		if(!$update){echo $sql; }else{ echo 1; }
	}
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>