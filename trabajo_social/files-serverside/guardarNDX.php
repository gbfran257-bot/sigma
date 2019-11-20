<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $nombre_ndx = sqlValue($_POST["nombre_ndx"], "text");
 $idU = sqlValue($_POST["id_u_ndx"], "int");
 $clave_ndx = sqlValue($_POST["clave_ndx"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
	
 mysql_select_db($database_horizonte, $horizonte); 
$sql="INSERT INTO diagnosticos(nombre_di,clave_di,usuario_di,fecha_di) VALUES ($nombre_ndx, $clave_ndx, $idU, $now)";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) { echo $sql; }else{  echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>