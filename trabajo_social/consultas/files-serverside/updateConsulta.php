<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $idUsuario = sqlValue($_POST["idUsuarioNC"], "int");
 $idConsulta = sqlValue($_POST["idConsulta"], "int");
 $nombre = sqlValue($_POST["nombreC"], "text");
 $idArea = sqlValue($_POST["areaC"], "int");
 $precio = sqlValue($_POST["precioC"], "double");
 $precioU = sqlValue($_POST["precioCurgencia"], "double");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
  
 $sql = "UPDATE conceptos SET concepto_to = $nombre, id_area_to = $idArea, precio_to = $precio, precio_urgencia_to = $precioU where id_to = $idConsulta limit 1";

mysql_select_db($database_horizonte, $horizonte);
$insertar = mysql_query($sql, $horizonte);
 	
if (!$insertar) { echo $sql; }else { echo 1; }
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>