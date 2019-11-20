<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idUsuario = sqlValue($_POST["idusuarioFI"], "int");
 $nombre = sqlValue(mb_strtoupper($_POST["nombreFI"]), "text");
 $formato = sqlValue($_POST["input"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 $a = sqlValue($_POST["a"], "text");
 $temporal = sqlValue($_POST["temporal"], "text");
 
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO formatos_conceptos(nombre_fc, formato_fc, temporal_fc, fecha_fc, id_concepto_fc, usuario_fc) VALUES($nombre, $formato, $temporal, $now, $a, $idUsuario)";	 
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) { echo $sql; }else{ echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>