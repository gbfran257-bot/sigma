<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $id = sqlValue($_POST["id_fp"], "int");
 $clave = trim(sqlValue(mb_strtoupper($_POST["fp"]), "text"));
//  $descripcion = trim(sqlValue(mb_strtoupper($_POST["descripcion"]), "text"));
 $idU = sqlValue($_POST["idU"], "int");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");

  
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "UPDATE catalogo_forma_pago set forma_pago_fp = $clave, id_usuario_fp = $idU, fecha_fp = $now where id_fp = $id limit 1";
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());    
	
 if(!$update){echo $sql;} else{echo 1;}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>