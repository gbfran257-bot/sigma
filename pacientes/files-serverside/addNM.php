<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $nombre = sqlValue($_POST["nombreNM"], "text");
 $apaterno = sqlValue($_POST["apaternoNM"], "text");
 $amaterno = sqlValue($_POST["amaternoNM"], "text");
 $identificador = sqlValue($_POST["idNM"], "text");
 $idUsuario = sqlValue($_POST["idUsuarioNM"], "int");

 mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO usuarios (idUsuarioR_u, nombre_u, apaterno_u, amaterno_u, foraneo_u, fecha_ingreso_u, clave_u, idPuesto_u)";
 $sql.= "VALUES ($idUsuario, $nombre, $apaterno, $amaterno, 1, now(), $identificador, 1 )";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) {
 	echo $sql;
 }else{ echo 'ok'; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>