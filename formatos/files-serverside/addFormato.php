<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idU = sqlValue($_POST["id_u"], "int");
 $formato = sqlValue($_POST["formato"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 $nombre = sqlValue(mb_strtoupper($_POST["nombre"]), "text");

 mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO formatos(nombre_fo, formato_fo, usuario_fo, fecha_nm) VALUES ($nombre, $formato, $idU, $now)";
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
 if (!$update) { echo $sql; }else{ echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>