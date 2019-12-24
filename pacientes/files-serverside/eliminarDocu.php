<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $id = sqlValue($_POST["id"], "int");
 
mysql_select_db($database_horizonte, $horizonte); 
$sql = "delete from documentos where id_do = $id limit 1";
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) { echo $sql; }else{  
	unlink("../documentos/files/".$id.'.'.$_POST["tipo"]);
	echo 1; 
}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>