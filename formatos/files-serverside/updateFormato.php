<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idU = sqlValue($_POST["id_u"], "int");
 $formato = sqlValue($_POST["formato"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 $nombre = sqlValue(mb_strtoupper($_POST["nombre"]), "text");
 $idF = sqlValue($_POST["id_f"], "int");

 mysql_select_db($database_horizonte, $horizonte);
 $sql = "UPDATE formatos set nombre_fo = $nombre, formato_fo = $formato, usuario_fo = $idU, fecha_nm = $now where id_fo = $idF";
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
 if (!$update) { echo $sql; }else{ echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>