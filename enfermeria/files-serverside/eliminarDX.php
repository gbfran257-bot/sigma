<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idDX = sqlValue($_POST["idDX"], "int");
 
 	mysql_select_db($database_horizonte, $horizonte); 
 	$sql = "delete from dx_consultas where id_dx_dxc = $idDX and temp_dxc = 1 limit 1";
	$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) { echo $sql; }else{  echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>