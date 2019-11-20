<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idUsuario = sqlValue($_POST["idusuarioNM"], "int");
 $nombre = sqlValue($_POST["nombreNM"], "text");
 $nota = sqlValue($_POST["input"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 $area = sqlValue($_POST["area_nota"], "int");
 
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO formatos(nombre_fo, formato_fo, usuario_fo, fecha_nm, id_area_fo)";
 $sql.= "VALUES ($nombre, $nota, $idUsuario, $now, $area)";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) { echo $sql; }else{ echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>