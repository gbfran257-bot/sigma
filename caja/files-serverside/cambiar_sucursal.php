<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $id_ns = sqlValue($_POST["id_ns"], "int");
 $id_u = sqlValue($_POST["id_u"], "int");
 $tempo = sqlValue($_POST["tempo"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
    
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "UPDATE orden_venta set sucursal_ov = $id_ns where no_temp_ov = $tempo limit 1";
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
 if (!$update) {echo $sql;} else{ echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>