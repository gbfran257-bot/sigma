<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idU = sqlValue($_POST["id_u"], "int");
 $idP = sqlValue($_POST["id_p"], "int");
 $costo_m = sqlValue($_POST["costo_m"], "double");
 $periodo_m = sqlValue($_POST["periodo_m"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 $now_i = sqlValue($_POST["fecha_i"], "date");
 $now_f = sqlValue($_POST["fecha_f"], "date");
    
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO membresias (id_paciente_me, fecha_i_me, fecha_f_me, id_usuario_me, fecha_me, costo_me ) VALUES ($idP, $now_i, $now_f, $idU, $now, $costo_m)";
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
 if (!$update) {echo $sql;} else{ echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>