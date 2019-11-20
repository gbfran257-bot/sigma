<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $id_c = sqlValue($_POST["id_c"], "int");
 mysql_select_db($database_horizonte, $horizonte); 
 $sql = "DELETE from venta_conceptos where id_concepto_es = $id_c limit 1";
 $sql_1 = "DELETE from venta_conceptos_1 where id_concepto_es = $id_c limit 1";
  
  $update = mysql_query($sql, $horizonte) or die (mysql_error());
  if (!$update) { echo $sql; }else{ 
  	echo 1;
	  
    $update_1 = mysql_query($sql_1, $horizonte) or die (mysql_error());
  }
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>