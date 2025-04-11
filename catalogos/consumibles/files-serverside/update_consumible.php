<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $id = sqlValue($_POST["idest"], "int");

 $nombre = sqlValue($_POST["nombre_n_cons"], "text");
 $descripcion = sqlValue($_POST["descripcion_n_cons"], "text");
 $tipo = sqlValue($_POST["tipo_n_cons"], "int");
 $unidad = sqlValue($_POST["unidad_n_cons"], "int");
 $presentacion = sqlValue($_POST["presentacion_n_cons"], "int");
 
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "UPDATE inventario SET item_i = $nombre, descripcion_i = $descripcion, id_tipo_i = $tipo, id_unidad_i = $unidad, id_presentacion_i = $presentacion WHERE id_i = $id LIMIT 1";
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());    
	
 if(!$update){echo $sql;} else{echo 1;}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>