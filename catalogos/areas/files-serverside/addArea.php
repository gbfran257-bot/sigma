<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");


$area = sqlValue(mb_strtoupper($_POST['area']), "text");
$clave = sqlValue(mb_strtoupper($_POST['abreviacion']), "text");
$idU = sqlValue($_POST["idU"], "int");
$now = sqlValue(date('Y-m-d H:i:s'), "date");

 mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO  areas (departamento_a, clave_a, nombre_a, usuario_a, fecha_a)";
 $sql.= "VALUES (4,$clave,$area,$idU,$now)";
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
 if(!$update){echo $sql;} else{echo 1;}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>