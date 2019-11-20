<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $id_sucu = sqlValue($_POST["id_sucu"], "int");
 $id_u = sqlValue($_POST["id_u"], "int");
 $tempo = sqlValue($_POST["tempo"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 
 mysql_select_db($database_horizonte, $horizonte);
 $resultS=mysql_query("SELECT count(id_su) from sucursales_usuarios where aleatorio_su = $tempo and id_sucursal_su = $id_sucu",$horizonte) or die (mysql_error());
 $rowS = mysql_fetch_row($resultS);
 
 mysql_select_db($database_horizonte, $horizonte);
 $resultP=mysql_query("SELECT count(id_su) from sucursales_usuarios where aleatorio_su = $tempo and primaria_su = 1",$horizonte) or die (mysql_error());
 $rowP = mysql_fetch_row($resultP); if($rowP[0]>0){$primario = 0;}else{$primario=1;}
 
 if($rowS[0]<1){
	 mysql_select_db($database_horizonte, $horizonte);
	 $sql = "INSERT INTO sucursales_usuarios(id_sucursal_su, usuario_su, fecha_su, primaria_su, aleatorio_su) VALUES($id_sucu, $id_u, $now, $primario, $tempo)";
	 $update = mysql_query($sql, $horizonte) or die (mysql_error());
		
	if(!$update){echo $sql; }else{ echo 1; }
 }else{echo 2;}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>