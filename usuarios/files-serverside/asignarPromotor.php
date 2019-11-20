<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idU = sqlValue($_POST["idUs"], "int");
 $idP = sqlValue($_POST["idP"], "int");

 mysql_select_db($database_horizonte, $horizonte);
 $sql = "UPDATE usuarios set promotor_u = $idP where id_u = $idU limit 1";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if(!$update){ echo $sql; }else{ echo 1;}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>