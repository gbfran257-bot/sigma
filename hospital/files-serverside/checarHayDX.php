<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idH = sqlValue($_POST["idH"], "int");
 $aleatorio = sqlValue($_POST["aleatorio"], "text");

 mysql_select_db($database_horizonte, $horizonte); 
 $resultC = mysql_query("SELECT count(id_dxh) from dx_hospital where id_hospitalizacion_dxh = $idH and aleatorio_dxh = $aleatorio", $horizonte) or die (mysql_error()); $rowC = mysql_fetch_row($resultC);
 
 mysql_select_db($database_horizonte, $horizonte); 
 $resultC2 = mysql_query("SELECT count(id_dxh) from dx_hospital where id_hospitalizacion_dxh = $idH and primario_dxh = 1", $horizonte) or die (mysql_error()); $rowC2 = mysql_fetch_row($resultC2);
 //Si no hay dx primario:
 if($rowC2[0]==0){
	 mysql_select_db($database_horizonte, $horizonte);
	 $sql1 = "UPDATE dx_hospital SET primario_dxh = 0 where id_hospitalizacion_dxh = $idH";
	 $update1 = mysql_query($sql1, $horizonte) or die (mysql_error());
	 if (!$update1) { echo $sql1; }else{ 
		 mysql_select_db($database_horizonte, $horizonte);
		 $sql = "UPDATE dx_hospital SET primario_dxh = 1 where id_hospitalizacion_dxh = $idH limit 1";
		 $update = mysql_query($sql, $horizonte) or die (mysql_error());	
		 if (!$update) { echo $sql; }else { echo $rowC[0]; }
	 }
 }else{echo $rowC[0];}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>