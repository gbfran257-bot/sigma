<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idD = sqlValue($_POST["idD"], "int");
 $val = sqlValue($_POST["num"], "int");


 mysql_select_db($database_horizonte, $horizonte);
 $sql = "UPDATE documentos SET num_suc_do = $val where id_do = $idD";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) {
 	echo $sql;
 }else{ 
    echo 1;
 }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>