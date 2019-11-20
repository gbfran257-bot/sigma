<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idC = sqlValue($_POST["id"], "int");
 $idUsuario = sqlValue($_POST["idU"], "int");
 $temporal = sqlValue($_POST["temporal"], "text");
 $concepto = sqlValue(mb_strtoupper($_POST["nombre"]), "text");
 $area = sqlValue($_POST["area"], "int");
 $precio = sqlValue($_POST["precio"], "double");
 $precioU = sqlValue($_POST["precioU"], "double");
 $precioM = sqlValue($_POST["precioM"], "double");
 $precioMU = sqlValue($_POST["precioMU"], "double");
 $precioH = sqlValue($_POST["precioH"], "double");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");

 mysql_select_db($database_horizonte, $horizonte);
 $sql = "UPDATE conceptos set concepto_to = $concepto, id_area_to = $area, precio_to = $precio, precio_urgencia_to = $precioU, precio_m = $precioM, precio_mu = $precioMU, precio_h = $precioH where id_to = $idC limit 1";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if(!$update){ echo $sql; }else{ echo 1;}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>