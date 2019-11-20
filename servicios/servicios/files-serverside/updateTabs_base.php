<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $idS = sqlValue($_POST["idServicio"], "int");
 $idUsuario = sqlValue($_POST["idUsuarioS"], "int");
 $nombre = sqlValue($_POST["nombreS"], "text");
 $precio = sqlValue($_POST["precioS"], "double");
 $precioU = sqlValue($_POST["precioUrgenciaS"], "double");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 
 $sql = "UPDATE conceptos SET concepto_to = $nombre, precio_to = $precio, precio_urgencia_to = $precioU where id_to = $idS limit 1";

mysql_select_db($database_horizonte, $horizonte);
$insertar = mysql_query($sql, $horizonte);
 	
if (!$insertar) { echo $sql; }else { echo 1; }
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>