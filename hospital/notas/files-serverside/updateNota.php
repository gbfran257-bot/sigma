<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $idN = sqlValue($_POST["idEstudioE"], "int");
 $nombre = sqlValue($_POST["nombreNM"], "text");
 $nota = sqlValue($_POST["input"], "text");
 $area = sqlValue($_POST["area_nota"], "int");
 
 $sql = "UPDATE notas_medicas SET nombre_nm = $nombre, nota_nm = $nota, id_area_nm = $area where id_nm = $idN limit 1";

mysql_select_db($database_horizonte, $horizonte);
$insertar = mysql_query($sql, $horizonte);
 	
if (!$insertar) { echo $sql; }else { echo 1; }
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>