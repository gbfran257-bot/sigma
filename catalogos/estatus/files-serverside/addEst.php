<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");


$estatus = sqlValue(mb_strtoupper($_POST['col_est']), "text");

 mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO estatus(estatus_est)";
 $sql.= "VALUES ($estatus)";
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
 if(!$update){echo $sql;} else{echo 1;}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>