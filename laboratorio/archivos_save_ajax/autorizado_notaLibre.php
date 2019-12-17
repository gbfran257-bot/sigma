<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idEvc = sqlValue($_POST["idE"], "int");
 $idP = sqlValue($_POST["idP"], "int");
 $idU = sqlValue($_POST["idU"], "int");
 $nota = sqlValue($_POST["notaPro"], "text");
 $nota_libre = sqlValue($_POST["notaLibre"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 
 if(isset($_POST["refPro"])){$ref = sqlValue($_POST["refPro"], "text");}else{$ref = '';}
 if(isset($_POST["checaPro"])){$checaPro = sqlValue($_POST["checaPro"], "int");}else{$checaPro = '';}
 
mysql_select_db($database_horizonte, $horizonte);
	$sql = "UPDATE venta_conceptos SET estatus_vc = 7, usuarioEdo4_e = $idU, fechaEdo4_e = $now, nota_radiologo_vc = $nota, interpretacion_vc = $nota_libre where id_vc = $idEvc ";
  
$update = mysql_query($sql, $horizonte);
	
if (!$update) { echo $sql; }else { echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>