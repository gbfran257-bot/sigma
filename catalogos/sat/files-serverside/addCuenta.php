<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");


$clave = sqlValue(trim(mb_strtoupper($_POST["clave"])), "text");
$descripcion = sqlValue(trim(mb_strtoupper($_POST["descripcion"])), "text");
$idU = sqlValue($_POST["idU"], "int");
$now = sqlValue(date('Y-m-d H:i:s'), "date");

 mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO  catalogo_sat (clave_sat, descripcion_sat, id_usuario_sat, fecha_sat)";
 $sql.= "VALUES ($clave,$desc,$idU,$now)";
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
 if(!$update){echo $sql;} else{echo 1;}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>