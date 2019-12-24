<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $id = sqlValue($_POST["id"], "int");
 
 mysql_select_db($database_horizonte, $horizonte);
 $resulP = mysql_query("SELECT nombre_do from documentos where id_do = $id ",$horizonte) or die (mysql_error());
 $rowP = mysql_fetch_row($resulP);
 
 $carpeta = $_POST["carpeta"].'/files/'.$id.'.'.$_POST["tipo"];
 $carpeta1 = $_POST["carpeta"].'/files/thumbnail/'.$id.'.'.$_POST["tipo"];
 
mysql_select_db($database_horizonte, $horizonte); 
$sql = "delete from documentos where id_do = $id limit 1";
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) { echo $sql; }else{ unlink($carpeta); unlink($carpeta1); echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>