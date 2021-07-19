<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $id_ref = sqlValue($_POST["id_ref"], "int");

//  $now = sqlValue(date('Y-m-d H:i:s'), "date");
  
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "DELETE FROM catalogo_valores_referencia WHERE id_cvr = $id_ref";
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
 if(!$update){echo $sql;} else{echo 1;}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>