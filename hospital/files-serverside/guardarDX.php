<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idH = sqlValue($_POST["idH"], "int");
 $idU = sqlValue($_POST["idU"], "int");
 $claveDX = sqlValue($_POST["claveDX"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 $aleatorio = sqlValue($_POST["aleatorio"], "text");
 
 mysql_select_db($database_horizonte, $horizonte); 
 $resultC = mysql_query("SELECT id_di from diagnosticos where clave_di = $claveDX ", $horizonte) or die (mysql_error());
 $rowC = mysql_fetch_row($resultC); $idDX = sqlValue($rowC[0], "int");
 	
 mysql_select_db($database_horizonte, $horizonte); 
 $sql="INSERT INTO dx_hospital(id_hospitalizacion_dxh,id_u_dxh,id_dx_dxh,fecha_dxh,aleatorio_dxh) VALUES($idH, $idU, $idDX, $now,$aleatorio)";
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
 if (!$update) { echo $sql; }else{  echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>