<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idC = sqlValue($_POST["idC"], "int");
 $idP = sqlValue($_POST["idP"], "int");
 $idU = sqlValue($_POST["idU"], "int");
 $idDX = sqlValue($_POST["idDX"], "int"); 
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 
 mysql_select_db($database_horizonte, $horizonte); 
 $resultCa = mysql_query("SELECT count(id_dxc) from dx_consultas where id_c_dxc = $idC and primario_dxc = 1", $horizonte) or die (mysql_error());
 $rowCa = mysql_fetch_row($resultCa); if($rowCa[0]==0){ $prim = 1; }else{$prim = 0;}
 
 mysql_select_db($database_horizonte, $horizonte); 
 $result = mysql_query("SELECT count(id_dxc) from dx_consultas where id_c_dxc = $idC and id_dx_dxc = $idDX", $horizonte) or die (mysql_error());
 $row = mysql_fetch_row($result);
 
 if($row[0]<1){
	mysql_select_db($database_horizonte, $horizonte); 
	 $sql="INSERT INTO dx_consultas(id_c_dxc,id_p_dxc,id_u_dxc,id_dx_dxc,fecha_dxc, primario_dxc) VALUES ($idC, $idP, $idU, $idDX, $now, $prim)";
	 $update = mysql_query($sql, $horizonte) or die (mysql_error());
		
	 if (!$update) { echo $sql; }else{ echo 1; } 
 }else{ echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>