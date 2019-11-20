<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $ref = sqlValue($_POST["refPro1"], "text");
 $idEvc = sqlValue($_POST["idEstudioPro"], "int");
 $idP = sqlValue($_POST["idPacientePro"], "int");
 $idU = sqlValue($_POST["idUserPro"], "int");
 $nota = sqlValue($_POST["notaPro"], "text");
 $checaPro = sqlValue($_POST["checaPro"], "int");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 
mysql_select_db($database_horizonte, $horizonte);
if($checaPro == 1){
	$sql = "UPDATE venta_conceptos SET estatus_vc = 3, usuarioEdo3_e = $idU, fechaEdo3_e = $now, nota_radiologo_vc = $nota where id_vc = $idEvc ";
}elseif($checaPro == 2){
	$sql = "UPDATE venta_conceptos v left join conceptos c on c.id_to = v.id_concepto_es SET v.estatus_vc = 3, v.usuarioEdo3_e = $idU, v.fechaEdo3_e = $now, v.nota_radiologo_vc = $nota where v.referencia_vc = $ref and v.estatus_vc = 2 and c.id_area_to = 55 ";
}
  
$update = mysql_query($sql, $horizonte);
	
if (!$update) { echo $sql;
 }else { echo 1; }
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>