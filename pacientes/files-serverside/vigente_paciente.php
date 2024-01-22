<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $id_p = sqlValue($_POST["id_p"], "int");
 $estado = sqlValue($_POST["estado"], "int");

 mysql_select_db($database_horizonte, $horizonte);

 if($estado==0){
    $estado = 1;
 }else if($estado==1){
    $estado = 0;
 }

 $sql = "UPDATE pacientes SET vigente = $estado WHERE id_p = $id_p";
  
 $update = mysql_query($sql, $horizonte);
	
 if (!$update) {
    echo $sql;
 }else{ 
    echo 1; 
 }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>