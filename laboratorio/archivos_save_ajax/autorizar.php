<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $ref = sqlValue($_POST["refPro"], "text");
 $idEvc = sqlValue($_POST["idEstudioPro"], "int");
 $idP = sqlValue($_POST["idPacientePro"], "int");
 $idU = sqlValue($_POST["idUserPro"], "int");
 //$nota = sqlValue($_POST["notaPro"], "text");
 $checaPro = sqlValue($_POST["checaPro"], "int");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 
mysql_select_db($database_horizonte, $horizonte);
if($checaPro == 1){ 
	$sql = "UPDATE venta_conceptos SET estatus_vc = 7, usuarioEdo4_e = $idU, fechaEdo4_e = $now where id_vc = $idEvc ";
}elseif($checaPro == 2){ 
	$sql = "UPDATE venta_conceptos SET estatus_vc = 7, usuarioEdo4_e = $idU, fechaEdo4_e = $now where referencia_vc = $ref and estatus_vc = 4 and tipo_concepto_vc = 3 "; 
}
  
$update = mysql_query($sql, $horizonte);
	
if (!$update) { echo $sql; }else { echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>