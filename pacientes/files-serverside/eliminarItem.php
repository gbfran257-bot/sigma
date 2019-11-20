<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idConcepto = sqlValue($_POST["idConcepto"], "int");
 
 	mysql_select_db($database_horizonte, $horizonte); 
 	$sql = "delete from venta_conceptos where id_vc = $idConcepto limit 1";
	$sql_1 = "delete from venta_conceptos_1 where id_vc = $idConcepto limit 1";
	$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) { echo $sql; }else{ 
	echo 1; 
	
	$update_1 = mysql_query($sql_1, $horizonte) or die (mysql_error());
}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>