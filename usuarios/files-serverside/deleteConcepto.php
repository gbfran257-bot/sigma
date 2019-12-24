<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idC = sqlValue($_POST["id"], "int");

 mysql_select_db($database_horizonte, $horizonte);
 $sql = "DELETE from conceptos where id_to = $idC limit 1";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if(!$update){ echo $sql; }else{ echo 1;}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>