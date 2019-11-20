<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idE = sqlValue($_POST["myIDestudio"], "int");
 $idU = sqlValue($_POST["myIDusuario"], "int");
 $interpretacion = sqlValue($_POST["input"], "text");
 $birad = sqlValue($_POST["birad_e"], "int");
 
mysql_select_db($database_horizonte, $horizonte);
 $sql = "UPDATE venta_conceptos SET interpretacion_vc = $interpretacion, estatus_vc = 4, usuarioEdo4_e = $idU, fechaEdo4_e = now(), birad_vc = $birad where id_vc = $idE limit 1";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) { echo $sql; }else { echo 1; }
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>