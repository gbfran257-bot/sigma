<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idUsuario = sqlValue($_POST["idUser_esc"], "int");
 $nombre = sqlValue(mb_strtoupper($_POST["nombre_esc"]), "text");
 $nivel = sqlValue($_POST["nivel_esc"], "int");
 $sector = sqlValue($_POST["sector_esc"], "text");
 $estado = sqlValue($_POST["estado_esc"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");

 // Verificamos si la escuela ya está registrada para evitar duplicados
 mysql_select_db($database_horizonte, $horizonte); //foto_u, firma_u, $foto, $firmaU, idOcupacion_u, $ocupacion, 
 $sql_verificacion = "SELECT id_e FROM catalogo_escuelas WHERE nombre_e IN({$nombre}) AND nivel_e = {$nivel} AND control_e IN({$sector}) AND entidad_e IN({$estado})";
 $resultado_verificacion = mysql_query($sql_verificacion, $horizonte);
 if (mysql_fetch_object($resultado_verificacion)->id_e) {
  die("La escuela {$nombre} ya se encuentra registrada, verifica los datos.");
 }

 mysql_select_db($database_horizonte, $horizonte); //foto_u, firma_u, $foto, $firmaU, idOcupacion_u, $ocupacion, 
 $sql = "INSERT INTO catalogo_escuelas(nombre_e, nivel_e, control_e, entidad_e, usuario_e, fecha_e)";
 $sql.= "VALUES ($nombre, $nivel, $sector, $estado, $idUsuario, $now)";
  //echo $sql;
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if(!$update){echo $sql; }else{ echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>