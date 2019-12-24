<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idUsuario = sqlValue($_POST["idUser_esc"], "int");
 $idEscuela = sqlValue($_POST["idEscuela"], "int");
 $nombre = sqlValue(mb_strtoupper($_POST["nombre_esc"]), "text");
 $nivel = sqlValue($_POST["nivel_esc"], "int");
 $sector = sqlValue($_POST["sector_esc"], "text");
 $estado = sqlValue($_POST["estado_esc"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");

 mysql_select_db($database_horizonte, $horizonte); //foto_u, firma_u, $foto, $firmaU, idOcupacion_u, $ocupacion, 
 $sql = "UPDATE catalogo_escuelas set nombre_e = $nombre, nivel_e = $nivel, control_e = $sector, entidad_e = $estado where id_e = $idEscuela limit 1";
  //echo $sql;
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if(!$update){echo $sql; }else{ echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>