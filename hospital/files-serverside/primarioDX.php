<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idDX = sqlValue($_POST["idDX"], "int");
 
 mysql_select_db($database_horizonte, $horizonte); 
 $resultC = mysql_query("SELECT id_hospitalizacion_dxh from dx_hospital where id_dxh = $idDX", $horizonte) or die (mysql_error());
 $rowC = mysql_fetch_row($resultC); $tempo_dx = sqlValue($rowC[0], "int");
 
 mysql_select_db($database_horizonte, $horizonte);
 $sql1 = "UPDATE dx_hospital SET primario_dxh = 0 where id_hospitalizacion_dxh = $tempo_dx";
 $update1 = mysql_query($sql1, $horizonte) or die (mysql_error());
 if (!$update1) { echo $sql1; }else{ 
 	mysql_select_db($database_horizonte, $horizonte);
 	$sql4 = "UPDATE dx_hospital SET primario_dxh = 1 where id_dxh = $idDX limit 1";
 	$update4 = mysql_query($sql4, $horizonte) or die (mysql_error());
 	if(!$update4) { echo $sql4; }else { echo 1; }
 }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>