<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idN = sqlValue($_POST["idEstudioE"], "int");
 $nombre = sqlValue($_POST["nombreNM"], "text");
 $nota = sqlValue($_POST["input"], "text");
 $area = sqlValue($_POST["area_nota"], "int");
 
 $sql = "UPDATE formatos SET nombre_fo = $nombre, formato_fo = $nota, id_area_fo = $area where id_fo = $idN limit 1";

mysql_select_db($database_horizonte, $horizonte);
$insertar = mysql_query($sql, $horizonte);
 	
if (!$insertar) { echo $sql; }else { echo 1; }
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>