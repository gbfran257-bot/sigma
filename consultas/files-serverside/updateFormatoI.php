<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $id = sqlValue($_POST["idFI"], "int");
 $nombre = sqlValue(mb_strtoupper($_POST["nombreFI"]), "text");
 $formato = sqlValue($_POST["input"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "UPDATE formatos_conceptos set nombre_fc = $nombre, formato_fc = $formato where id_fc = $id";
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
 if (!$update) { echo $sql; }else{ echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>