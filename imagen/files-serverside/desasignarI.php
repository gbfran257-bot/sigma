<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idE = sqlValue($_POST["idVC"], "int");
 
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "UPDATE venta_conceptos SET id_radiologo_externo = 0, usuario_transfiere_vc = NULL, fecha_transfiere_vc = NULL where id_vc = $idE limit 1";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) { echo $sql; }else { echo 1; }
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>