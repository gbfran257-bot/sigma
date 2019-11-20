<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idE = sqlValue($_POST["idE"], "int"); $idU = sqlValue($_POST["idU"], "int");
 $idB = sqlValue($_POST["id_b"], "int"); $now = sqlValue(date('Y-m-d H:i:s'), "date");
 
 mysql_select_db($database_horizonte, $horizonte); 
 $result = mysql_query("SELECT count(id_rl) from resultados_laboratorio where id_estudio_vc_rl = $idE and boleano_rl = 1 and id_base_rl = $idB",$horizonte) or die (mysql_error());
 $row = mysql_fetch_row($result);
 
 if($row[0]==0){
	mysql_select_db($database_horizonte, $horizonte);
 	$sql = "UPDATE resultados_laboratorio SET boleano_rl = 1, valor_texto_rl = '' where id_estudio_vc_rl = $idE and id_base_rl = $idB ";
 	$update = mysql_query($sql, $horizonte);
	
	if (!$update) { echo $sql; }else { echo 1; }
 }else{echo 1;}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>