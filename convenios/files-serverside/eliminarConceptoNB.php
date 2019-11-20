<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idConcepto = sqlValue($_POST["idConcepto"], "int");
 
 	mysql_select_db($database_horizonte, $horizonte); 
 	$sql = "delete from asigna_conceptos_convenios where id_ac = $idConcepto limit 1";
	$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) { echo $sql; }else{  echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>