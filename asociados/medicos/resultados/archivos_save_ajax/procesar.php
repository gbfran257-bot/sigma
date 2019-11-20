<?php
require("../../../../Connections/horizonte.php");
require("../../../../funciones/php/values.php");

 $ref = sqlValue($_POST["refPro"], "text");
 $idEvc = sqlValue($_POST["idEstudioPro"], "int");
 $idP = sqlValue($_POST["idPacientePro"], "int");
 $idU = sqlValue($_POST["idUserPro"], "int");
 $nota = sqlValue($_POST["notaPro"], "text");
 $checaPro = sqlValue($_POST["checaPro"], "int");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 
mysql_select_db($database_horizonte, $horizonte);
if($checaPro == 1){
	$sql = "UPDATE venta_conceptos SET estatus_vc = 2, usuarioEdo2_e = $idU, fechaEdo2_e = $now, nota_radiologo_vc = $nota where id_vc = $idEvc ";
}elseif($checaPro == 2){
	$sql = "UPDATE venta_conceptos SET estatus_vc = 2, usuarioEdo2_e = $idU, fechaEdo2_e = $now, nota_radiologo_vc = $nota where referencia_vc = $ref and estatus_vc = 1 and area_vc = 55 ";
}
  
$update = mysql_query($sql, $horizonte);
	
if (!$update) {
 	echo $sql;
 }else {
	 echo 1;
}
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>