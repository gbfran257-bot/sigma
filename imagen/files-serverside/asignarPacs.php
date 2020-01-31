<?php
require("../../Connections/ipacs.php");
require("../../funciones/php/values.php");

 //$pkPacs = sqlValue($_POST["pkPacs"], "int");
 //$idPacsVC = sqlValue($_POST["idPacsVC"], "text");
 $pkPacs = ($_POST["pkPacs"]);
 $idPacsVC = "'".($_POST["idPacsVC"])."'";
 
 //Ponemos en xxx000 el idpacs de otros patient
 //mysql_select_db($database_ipacs, $ipacs);
 $sql1 = "UPDATE patient SET pat_id = null where pat_id = $idPacsVC";
 $update1 = pg_query($ipacs, $sql1);
 
 //if (!$update1) { echo $sql1; }else {
 	//mysql_select_db($database_ipacs, $ipacs);
 	$sql = "UPDATE patient SET pat_id = $idPacsVC where pk = $pkPacs ";
 	$update = pg_query($ipacs, $sql);
	
	if(!$update) { echo $sql; }else { echo 1; }	 
 //}
 
 //Cerrar conexión a la Base de Datos
pg_close($ipacs);
?>
