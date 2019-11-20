<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idDX = sqlValue($_POST["idDX"], "int"); $idC = sqlValue($_POST["idC"], "int");
 
 mysql_select_db($database_horizonte, $horizonte); 
 $sql = "delete from dx_consultas where id_dxc = $idDX and id_c_dxc = $idC limit 1";
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
 
if(!$update){ echo $sql; }else{
	mysql_select_db($database_horizonte, $horizonte); 
 	$resultC=mysql_query("SELECT count(id_dxc) from dx_consultas where id_c_dxc = $idC and primario_dxc",$horizonte) or die (mysql_error());
 	$rowC = mysql_fetch_row($resultC);
	
	if($rowC[0]<1){
		mysql_select_db($database_horizonte, $horizonte);
		$sql4 = "UPDATE dx_consultas SET primario_dxc = 1 where id_c_dxc = $idC limit 1";
		$update4 = mysql_query($sql4, $horizonte) or die (mysql_error());
		if (!$update4) { echo $sql4; }else { echo 1; }
	} else{echo 1;}
}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>