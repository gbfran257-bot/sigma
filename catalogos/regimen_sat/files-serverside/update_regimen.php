<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $id = sqlValue($_POST["id_sat"], "int");
 $clave = trim(sqlValue(mb_strtoupper($_POST["clave"]), "text"));
 $descripcion = trim(sqlValue(mb_strtoupper($_POST["descripcion"]), "text"));
 $idU = sqlValue($_POST["idU"], "int");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 $publicacion = sqlValue($_POST["publicacion"], "date");

 
  
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "UPDATE catalogo_regimen_sat set clave_reg = $clave, descripcion_reg = $descripcion, publicacion_reg= $publicacion, usuario_reg = $idU, fecha_reg = $now where clave_reg = $clave limit 1";
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());    
	
 if(!$update){echo $sql;} else{echo 1;}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>