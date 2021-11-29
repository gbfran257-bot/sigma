<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$id_n = sqlValue($_POST["id_n"], "int");
$nota = sqlValue($_POST["nota"], "text");

mysql_select_db($database_horizonte, $horizonte); 
$sql="UPDATE notas_de_hospital SET nota_nh = $nota WHERE id_nh = $id_n ";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) { echo $sql; }else{  echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>