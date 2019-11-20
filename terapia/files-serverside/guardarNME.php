<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $nombre = sqlValue($_POST["nombre_nmE"], "text");
 $apaterno = sqlValue($_POST["apaterno_nmE"], "text");
 $amaterno = sqlValue($_POST["amaterno_nmE"], "text");
 $idU = sqlValue($_POST["id_u_nm"], "int");
 $clave = sqlValue($_POST["clave_nmE"], "text");
 $telefono = sqlValue($_POST["telefono_nmE"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
	
 mysql_select_db($database_horizonte, $horizonte); 
 $sql="INSERT INTO usuarios(nombre_u,apaterno_u,amaterno_u,clave_u,tCelular_u, idUsuarioR_u, fecha_ingreso_u, idPuesto_u, foraneo_u, especialidad_u) VALUES ($nombre, $apaterno, $amaterno, $clave, $telefono, $idU, $now, 1, 1, 1)";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) { echo $sql; }else{  echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>