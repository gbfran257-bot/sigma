<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $id = sqlValue($_POST["id"], "int");
 
mysql_select_db($database_horizonte, $horizonte); 
$sql = "delete from venta_conceptos where id_vc = $id limit 1";
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) { echo $sql; }else{  
	echo 1; 
	/*mysql_select_db($database_horizonte, $horizonte); 
	$sql1 = "delete from pagos_ov where id_vc_pag = $id";
	$update1 = mysql_query($sql1, $horizonte) or die (mysql_error());
		
	if (!$update1) { echo $sql1; }else{  
		echo 1; 
	}*/
}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>