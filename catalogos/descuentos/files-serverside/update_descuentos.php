<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $id = sqlValue($_POST["idest"], "int");
 $concepto = sqlValue($_POST["conceptoDescuento"], "text");
 $tipo = sqlValue($_POST["tipoDes"], "text");
 $cantidad = sqlValue($_POST["cantidadDes"], "text");
 $idU = sqlValue($_POST["idU"], "int");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");

  
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "UPDATE catalogo_descuentos set nombre_des = $concepto, tipo_des = $tipo, descuento_des = $cantidad, usuario_des = $idU, fecha_des = $now where id_des = $id limit 1";
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());    
	
 if(!$update){echo $sql;} else{echo 1;}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>