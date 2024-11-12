<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $id_to = sqlValue($_POST['id_to'],'int');
 $id_s = sqlValue($_POST['id_s'],'int');
 $id_u = sqlValue($_POST['id_u'],'int');
 $precio = sqlValue($_POST['precio'], 'double');
 $precio_u = sqlValue($_POST['precio_u'], 'double');
 $now = sqlValue(date('Y-m-d H:i:s'), "date");

 if(isset($_POST['id_to'])){
    $sql = "UPDATE conceptos SET ".$id_s."_precio = $precio, ".$id_s."_precio_u = $precio_u, usuario_to = $id_u, fecha_to = $now WHERE id_to = $id_to LIMIT 1";
    
    mysql_select_db($database_horizonte, $horizonte);
    $actualizar = mysql_query($sql, $horizonte);
        
    if (!$actualizar){
        echo $sql; 
    }else{ 
        echo 1; 
    }
 }
   

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>