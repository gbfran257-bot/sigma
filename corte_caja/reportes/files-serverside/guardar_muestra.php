<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");
//Generales
 $noRef = sqlValue($_POST["id"], "int");
 $user = sqlValue($_POST["user"], "int");
 $muestra = sqlValue($_POST["val"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 
 $sqlF = "UPDATE orden_venta set muestras_ov = $muestra where id_ov = $noRef limit 1;";
 
 mysql_select_db($database_horizonte, $horizonte);
 $insertarF = mysql_query($sqlF, $horizonte) or die (mysql_error());
 if (!$insertarF){ echo $sqlF;} else {echo 1;}
	
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>