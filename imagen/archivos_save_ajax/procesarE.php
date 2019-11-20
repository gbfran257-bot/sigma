<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idE = sqlValue($_POST["idC"], "int");
 $idU = sqlValue($_POST["idU"], "int");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 $dxEnvio = sqlValue(mb_strtoupper($_POST["dxEnvio"]), "text");
 $anestesiologo = sqlValue($_POST["anestesiologo"], "int");
 
	mysql_select_db($database_horizonte, $horizonte);
	$sql = "UPDATE venta_conceptos SET estatus_vc = 2, usuarioEdo2_e = $idU, fechaEdo2_e = $now, id_anesteciologo_vc = $anestesiologo where id_vc = $idE ";
  
$update = mysql_query($sql, $horizonte);
	
if (!$update) {
 	echo $sql;
 }else {
	
	mysql_select_db($database_horizonte, $horizonte);
	$queryT = mysql_query("SELECT referencia_vc FROM venta_conceptos where id_vc = $idE", $horizonte) or die (mysql_error());
    $rowT = mysql_fetch_row($queryT); $refe = sqlValue($rowT[0], "text");
	
	mysql_select_db($database_horizonte, $horizonte);
	$sql1 = "UPDATE orden_venta SET observaciones_i_ov = $dxEnvio where referencia_ov = $refe ";
  
	$update1 = mysql_query($sql1, $horizonte);

	 echo 1;
}
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>