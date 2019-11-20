<?php
require("../Connections/horizonte.php");
require("../funciones/php/values.php");

$referencia = sqlValue($_POST["referenciaEstudio"], "text");
$curp = sqlValue($_POST["curp"], "text"); 
$numero = sqlValue($_POST["numeroE"], "int"); 

mysql_select_db($database_horizonte, $horizonte);
$resultP = mysql_query("SELECT id_p from pacientes where curp_p = $curp limit 1 ", $horizonte) or die (mysql_error());
$rowP = mysql_fetch_row($resultP); $idP = $rowP[0];

mysql_select_db($database_horizonte, $horizonte);

$result1 = mysql_query("SELECT id_vc, tipo_concepto_vc, estatus_vc, id_concepto_es, departamento_vc from venta_conceptos where referencia_vc = $referencia and contador_vc = $numero and id_paciente_vc = $idP ", $horizonte) or die (mysql_error());
$row1 = mysql_fetch_row($result1); $idD=sqlValue($row1[4],"int"); $idTE=sqlValue($row1[3], "int"); $idST = sqlValue($row1[2], "int");

mysql_select_db($database_horizonte, $horizonte);
$resultST = mysql_query("SELECT estatus_est from estatus where id_est = $idST limit 1 ", $horizonte) or die (mysql_error());
$rowST = mysql_fetch_row($resultST);

mysql_select_db($database_horizonte, $horizonte);
$resultE = mysql_query("SELECT concepto_to from conceptos where id_to = $idTE limit 1 ", $horizonte) or die (mysql_error());
$rowE = mysql_fetch_row($resultE);

mysql_select_db($database_horizonte, $horizonte);
$resultD = mysql_query("SELECT nombre_d from departamentos where id_d = $idD limit 1 ", $horizonte) or die (mysql_error());
$rowD = mysql_fetch_row($resultD);

$nombreP = $rowD[0].'};['.$rowE[0].'};['.$row1[0].'};['.$row1[1].'};['.$rowST[0].'};['.$row1[2];

echo $nombreP;

mysql_close($horizonte);
?>