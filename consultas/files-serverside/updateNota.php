<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idNM = sqlValue($_POST["idNM"], "int");
 $nombre = sqlValue(mb_strtoupper($_POST["nombreNM"]), "text");
 $nota = sqlValue($_POST["input"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "UPDATE notas_medicas set nombre_nm = $nombre, nota_nm = $nota where id_nm = $idNM";
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
 if (!$update) { echo $sql; }else{ echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>