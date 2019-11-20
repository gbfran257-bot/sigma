<?php
require("../../Connections/ipacs.php");
require("../../funciones/php/values.php");

 $pkPacs = sqlValue($_POST["pkPacs"], "int");
 $idPacsVC = sqlValue($_POST["idPacsVC"], "text");
 
 //Ponemos en xxx000 el idpacs de otros patient
 mysql_select_db($database_ipacs, $ipacs);
 $sql1 = "UPDATE patient SET pat_id = '000_xxx' where pat_id = $idPacsVC";
 $update1 = mysql_query($sql1, $ipacs) or die (mysql_error());
 
 if (!$update1) { echo $sql1; }else {
 	mysql_select_db($database_ipacs, $ipacs);
 	$sql = "UPDATE patient SET pat_id = $idPacsVC where pk = $pkPacs limit 1";
 	$update = mysql_query($sql, $ipacs) or die (mysql_error());
	
	if(!$update) { echo $sql; }else { echo 1; }	 
 }
 
 //Cerrar conexión a la Base de Datos
 mysql_close($ipacs);
?>