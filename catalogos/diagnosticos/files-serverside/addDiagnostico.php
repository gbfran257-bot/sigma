<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");


$clave = sqlValue(mb_strtoupper($_POST['clave']), "text");
$diag = sqlValue(mb_strtoupper($_POST['diagno']), "text");
$idU = sqlValue($_POST["idU"], "int");
$now = sqlValue(date('Y-m-d H:i:s'), "date");

 mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO  diagnosticos (clave_di, nombre_di, usuario_di, fecha_di)";
 $sql.= "VALUES ($clave,$diag,$idU,$now)";
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
 if(!$update){echo $sql;} else{echo 1;}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>