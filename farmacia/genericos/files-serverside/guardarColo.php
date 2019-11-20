<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idEstado = sqlValue($_POST["estadoNM"], "int");
 $idMunicipio = sqlValue($_POST["municipioNM"], "int");
 $colonia = sqlValue($_POST["nombre_nc"], "text");
 $cp = sqlValue($_POST["cp_n"], "text");
 $idU = sqlValue($_POST["id_u_nmuni"], "int");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 
 	mysql_select_db($database_horizonte, $horizonte);
 	$result = mysql_query("SELECT d_estado, d_municipio from mexico where id_mx = $idMunicipio limit 1", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result); $miEstado = sqlValue($row[0], "text"); $miMunicipio = sqlValue($row[1], "text");
	
 mysql_select_db($database_horizonte, $horizonte); 
 $sql="INSERT INTO mexico(d_estado, d_municipio, usuario_mx, fecha_mx, d_asenta, d_codigo) VALUES ($miEstado, $miMunicipio, $idU, $now, $colonia, $cp)";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) { echo $sql; }else{  echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>