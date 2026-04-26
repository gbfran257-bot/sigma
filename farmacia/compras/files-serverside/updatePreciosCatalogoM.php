<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

$id_to = sqlValue($_POST['id_to'],'int');
$id_s = sqlValue($_POST['id_s'],'int');
$precio = sqlValue($_POST['precio'], 'double');
$usuario = sqlValue($_POST['usuario'], 'int');
$now = sqlValue(date('Y-m-d H:i:s'), "date");

if(isset($_POST['id_to'])){
   $sql = "UPDATE conceptos SET ".$id_s."_precio = $precio, ".$id_s."_precio_u = $precio, usuario_to = $usuario, fecha_to = $now WHERE id_to = $id_to AND id_tipo_concepto_to = 5 LIMIT 1";
   
   mysql_select_db($database_horizonte, $horizonte);
   $actualizar = mysql_query($sql, $horizonte);
       
   if (!$actualizar){
       echo $sql; 
   }else{ 
       echo 1; 
   }
}


?>
