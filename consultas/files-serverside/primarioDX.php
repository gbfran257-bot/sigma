<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idDX = sqlValue($_POST["idDX"], "int");
 $id_c = sqlValue($_POST["idC"], "int");
 
 mysql_select_db($database_horizonte, $horizonte);
 $sql1 = "UPDATE dx_consultas SET primario_dxc = 0 where id_c_dxc = $id_c";
 $update1 = mysql_query($sql1, $horizonte) or die (mysql_error());
 if (!$update1) { echo $sql1; }else{ 
 	mysql_select_db($database_horizonte, $horizonte);
 	$sql4 = "UPDATE dx_consultas SET primario_dxc = 1 where id_dxc = $idDX limit 1";
 	$update4 = mysql_query($sql4, $horizonte) or die (mysql_error());
 	if(!$update4) { echo $sql4; }else { echo 1; }
 }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>