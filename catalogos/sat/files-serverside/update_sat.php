<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $id = sqlValue($_POST["id_sat"], "int");
 $clave = trim(sqlValue(mb_strtoupper($_POST["clave"]), "text"));
 $descripcion = trim(sqlValue(mb_strtoupper($_POST["descripcion"]), "text"));
 $idU = sqlValue($_POST["idU"], "int");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");

  
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "UPDATE catalogo_sat set clave_sat = $clave, descripcion_sat = $descripcion, id_usuario_sat = $idU, fecha_sat = $now where id_sat = $id limit 1";
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());    
	
 if(!$update){echo $sql;} else{echo 1;}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>