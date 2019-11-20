<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $idUsuario = sqlValue($_POST["id_u"], "int");
 $area = sqlValue(mb_strtoupper($_POST["nombre"]), "text");
 $clave = sqlValue(mb_strtoupper($_POST["clave"]), "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");

 mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO areas (departamento_a, nombre_a, usuario_a, fecha_a, clave_a)";
 $sql.= "VALUES (1, $area, $idUsuario, $now, $clave)";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) { echo $sql; }else{ echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>