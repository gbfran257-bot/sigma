<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idE = sqlValue($_POST["idE"], "int");
 $idU = sqlValue($_POST["idU"], "int");
 $dx = sqlValue($_POST["dx"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 
mysql_select_db($database_horizonte, $horizonte); // El estatus debe ser 4, por lo mientras pondré 2
 $sql = "UPDATE venta_conceptos SET interpretacion_vc = $dx, estatus_vc = 4, usuarioEdo4_e = $idU, fechaEdo4_e = $now where id_vc = $idE limit 1";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) { echo $sql; }else { echo 1; }
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>