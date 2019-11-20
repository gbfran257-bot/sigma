<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $id_u = sqlValue($_POST["id_u"], "int");
 
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "UPDATE usuarios set validado_u = 1, usuarioNuevo_u = 0 where id_u = $id_u limit 1;";
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
 if(!$update){ echo $sql; }else{ echo 1;}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>