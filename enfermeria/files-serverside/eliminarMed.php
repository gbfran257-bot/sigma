<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idMEDC = sqlValue($_POST["idMEDC"], "int");
 
 	mysql_select_db($database_horizonte, $horizonte); 
 	$sql = "delete from medicamentos_receta where id_mr = $idMEDC and temp_mr = 1 limit 1";
	$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) { echo $sql; }else{  echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>