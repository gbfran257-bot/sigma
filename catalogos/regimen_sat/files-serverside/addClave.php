<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");


$clave = sqlValue(trim(mb_strtoupper($_POST["clave"])), "text");
$descripcion = sqlValue(trim(mb_strtoupper($_POST["descripcion"])), "text");
$publicacion = sqlValue($_POST["publicacion"], "date");
$idU = sqlValue($_POST["idU"], "int");
$now = sqlValue(date('Y-m-d H:i:s'), "date");


 mysql_select_db($database_horizonte, $horizonte);
    $sql = "INSERT INTO  catalogo_regimen_sat (clave_reg, descripcion_reg, publicacion_reg, usuario_reg, fecha_reg)";
    $sql.= "VALUES ($clave,$descripcion,$publicacion,$idU,$now)";
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
 if(!$update){echo $sql;} else{echo 1;}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>