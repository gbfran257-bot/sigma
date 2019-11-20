<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idE = sqlValue($_POST["idE"], "int");
 $medico = sqlValue($_POST["medico"], "int");
 $idU = sqlValue($_POST["idU"], "int");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 
 mysql_select_db($database_horizonte, $horizonte);
 $result1 = mysql_query("select count(id_as) from acceso_simple where id_u_as = $medico and id_vc_as = $idE ", $horizonte) or die (mysql_error());
 $row1 = mysql_fetch_row($result1);
 
 if($row1[0]<1){
	 mysql_select_db($database_horizonte, $horizonte);
 	$sql = "insert into acceso_simple (id_u_as, id_vc_as, usuario_as, fecha_as) values($medico, $idE, $idU, $now) ";
 	$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
 	if (!$update) { echo $sql; }else { echo 1; }
 }else{echo 2;}
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>