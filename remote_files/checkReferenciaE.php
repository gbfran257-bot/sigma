<?php
require("../Connections/horizonte.php");
require("../funciones/php/values.php");

$referencia = sqlValue($_POST["referencia"], "text"); 
$curp = sqlValue($_POST["curp"], "text"); 
$numero = sqlValue($_POST["numero"], "int"); 

mysql_select_db($database_horizonte, $horizonte);
$resultP = mysql_query("SELECT id_p from pacientes where curp_p = $curp limit 1 ", $horizonte) or die (mysql_error());
$rowP = mysql_fetch_row($resultP); $idP = $rowP[0];

mysql_select_db($database_horizonte, $horizonte);

$result1 = mysql_query("SELECT COUNT(id_vc) from venta_conceptos where id_paciente_vc = $idP and referencia_vc = $referencia and contador_vc = $numero and tipo_concepto_vc in (3,4,5) limit 1 ", $horizonte) or die (mysql_error());
$row1 = mysql_fetch_row($result1);

//si alguien que no sea este productor tiene el crup
if($row1[0]>0){
	echo 'true';
}//si nadie lo tiene
else{
	echo 'false';
}

mysql_close($horizonte);
?>