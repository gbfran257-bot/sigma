<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $idUsuario = sqlValue($_POST["idUsuarioE"], "int");
 $nombre = sqlValue($_POST["nombreE"], "text");
 $precio = sqlValue($_POST["precioE"], "double");
 $precioU = sqlValue($_POST["precioUrgenciaE"], "double");
 $precio1 = sqlValue($_POST["precioE1"], "double");
 $precioU1 = sqlValue($_POST["precioUrgenciaE1"], "double");
 $idArea = sqlValue($_POST["areaE"], "int");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 $noTemp = sqlValue(date('Y-m-d-H-i-s'), "date");
 $dEntrega = sqlValue($_POST["dEntregaE"], "int");

 mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO conceptos (usuario_to, concepto_to, precio_to, precio_urgencia_to, id_area_to, fecha_to, id_departamento_to, id_tipo_concepto_to, aleatorio_c, dias_entrega_to, precio1_to, precio_urgencia1_to)";
 $sql.= "VALUES ($idUsuario, $nombre, $precio, $precioU, $idArea, $now, 1, 3, $noTemp, $dEntrega, $precio1, $precioU1)";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) { echo $sql; }else{ echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>