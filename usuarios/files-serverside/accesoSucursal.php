<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $id = sqlValue($_POST["id"], "int"); $valor = sqlValue($_POST["valor"], "int");
  
 mysql_select_db($database_horizonte, $horizonte); 
 $sql1 = "update sucursales_usuarios set acceso_su = $valor where id_su = $id limit 1";
 $update1 = mysql_query($sql1, $horizonte) or die (mysql_error());

 if (!$update1) { echo $sql1; }else{ echo 1;}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>