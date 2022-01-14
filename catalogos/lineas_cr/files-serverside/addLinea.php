<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");


$linea = sqlValue(mb_strtoupper($_POST['linea']), "text");
$desc = sqlValue(mb_strtoupper($_POST['descripcion']), "text");
$idU = sqlValue($_POST["idU"], "int");
$now = sqlValue(date('Y-m-d H:i:s'), "date");

 mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO  catalogo_lineas_cr (nombre_l, descripcion_l, usuario_l, fecha_l)";
 $sql.= "VALUES ($linea,$desc,$idU,$now)";
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
 if(!$update){echo $sql;} else{echo 1;}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>