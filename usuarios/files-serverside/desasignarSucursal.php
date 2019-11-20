<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $id = sqlValue($_POST["id"], "int");
 mysql_select_db($database_horizonte, $horizonte);
 $resultS=mysql_query("SELECT primaria_su, aleatorio_su from sucursales_usuarios where id_su = $id",$horizonte) or die (mysql_error());
 $rowS = mysql_fetch_row($resultS); $aleat = sqlValue($rowS[1], "text");
 
 mysql_select_db($database_horizonte, $horizonte); 
 $sql = "delete from sucursales_usuarios where id_su = $id limit 1";
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
 if (!$update) { echo $sql; }else{
	if($rowS[0]==1){
		mysql_select_db($database_horizonte, $horizonte); 
 		$sql1 = "update sucursales_usuarios set primaria_su = 1 where aleatorio_su = $aleat order by id_su asc limit 1";
 		$update1 = mysql_query($sql1, $horizonte) or die (mysql_error());
		
		if (!$update1) { echo $sql1; }else{ echo 1;}
	}else{echo 1;}
 }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>