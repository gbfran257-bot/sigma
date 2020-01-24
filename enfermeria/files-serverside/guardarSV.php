<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idP = sqlValue($_POST["idPx1"], "int");
 $idC = sqlValue($_POST["idC"], "int");
 $idU = sqlValue($_POST["idU"], "int");
 $peso = sqlValue($_POST["peso"], "double");
 $talla = sqlValue($_POST["talla"], "double");
 $cintura = sqlValue($_POST["cintura"], "double");
 $imc = sqlValue($_POST["imc"], "double");
 $t = sqlValue($_POST["t"], "int");
 $a = sqlValue($_POST["a"], "int");
 $fr = sqlValue($_POST["fr"], "int");
 $fc = sqlValue($_POST["fc"], "int");
 $temp = sqlValue($_POST["temp"], "double");
 $notas = sqlValue($_POST["notas"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 $oximetria = sqlValue($_POST["oximetria"], "int");
 $aocular = sqlValue($_POST["aocular"], "int");
 $rverbal = sqlValue($_POST["rverbal"], "int");
 $rmotriz = sqlValue($_POST["rmotriz"], "int");

 mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO signos_vitales (id_paciente_sv, id_usuario_sv, fecha_sv, peso_sv, talla_sv, imc_sv, cintura_sv, t_sv, a_sv, fr_sv, fc_sv, temperatura_sv, notas_sv, oximetria_sv, a_ocular_sv, r_verbal, r_motriz)";
 $sql.= "VALUES ($idP, $idU, $now, $peso, $talla, $imc, $cintura, $t, $a, $fr, $fc, $temp, $notas, $oximetria, $aocular, $rverbal, $rmotriz )";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) { echo $sql; }else{
	mysql_select_db($database_horizonte, $horizonte); 
	 $resultS= mysql_query("SELECT id_sv from signos_vitales order by id_sv desc limit 1", $horizonte) or die (mysql_error());
	 $rowS = mysql_fetch_row($resultS); $id_sv = sqlValue($rowS[0], "int");
 
	mysql_select_db($database_horizonte, $horizonte);
 	$sqlY = "UPDATE venta_conceptos SET id_signosv_vc = $id_sv where id_vc = $idC and id_paciente_vc = $idP limit 1";
	$updateY = mysql_query($sqlY, $horizonte) or die (mysql_error());
	
	if (!$updateY) { echo $sqlY; }else {echo 1;}
}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>
