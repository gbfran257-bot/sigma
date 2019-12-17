<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $idE = sqlValue($_POST["idEstudioE"], "int");
 $nombre = sqlValue($_POST["nombreE"], "text");
 $precio = sqlValue($_POST["precioE"], "double");
 $precioU = sqlValue($_POST["precioUrgenciaE"], "double");
 $precio1 = sqlValue($_POST["precioE1"], "double");
 $precioU1 = sqlValue($_POST["precioUrgenciaE1"], "double");
 $idArea = sqlValue($_POST["areaE"], "int");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 $dEntrega = sqlValue($_POST["dEntregaE"], "int");
   
 $sql = "UPDATE conceptos SET concepto_to = $nombre, precio_to = $precio, precio_urgencia_to = $precioU, dias_entrega_to = $dEntrega, precio1_to = $precio1, precio_urgencia1_to = $precioU1 where id_to = $idE limit 1";

mysql_select_db($database_horizonte, $horizonte);
$insertar = mysql_query($sql, $horizonte);
 	
if (!$insertar) { echo $sql; }else { echo 1; }
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>