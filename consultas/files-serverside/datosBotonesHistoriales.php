<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$idP = sqlValue($_POST["idP"], "int");

mysql_select_db($database_horizonte, $horizonte);// para lab
$resultLab = mysql_query("SELECT count(v.id_vc) from venta_conceptos v left join conceptos c on c.id_to = v.id_concepto_es where v.id_paciente_vc = $idP and v.temporal_vc = 0 and c.id_tipo_concepto_to = 3 and v.estatus_vc > 6 and c.concepto_to!='' ", $horizonte) or die (mysql_error());
$rowLab = mysql_fetch_row($resultLab);

mysql_select_db($database_horizonte, $horizonte); //Para USG
$resultUSG = mysql_query("SELECT count(v.id_vc) from venta_conceptos v left join conceptos c on c.id_to = v.id_concepto_es where v.id_paciente_vc = $idP and v.temporal_vc = 0 and c.id_tipo_concepto_to = 4 and v.estatus_vc = 5 and c.concepto_to != '' and c.id_area_to = 58 ", $horizonte) or die (mysql_error());
$rowUSG = mysql_fetch_row($resultUSG);

mysql_select_db($database_horizonte, $horizonte); //Para IMG
$resultIMG = mysql_query("SELECT count(v.id_vc) from venta_conceptos v left join conceptos c on c.id_to = v.id_concepto_es where v.id_paciente_vc = $idP and c.id_tipo_concepto_to = 4 and v.estatus_vc >= 5 and c.id_area_to not in (29,58,85)", $horizonte) or die (mysql_error());
$rowIMG = mysql_fetch_row($resultIMG);

mysql_select_db($database_horizonte, $horizonte); //Para ENDO
$resultENDO = mysql_query("SELECT count(v.id_vc) from venta_conceptos v left join conceptos c on c.id_to = v.id_concepto_es where v.id_paciente_vc = $idP and c.id_tipo_concepto_to = 4 and v.estatus_vc = 5 and c.id_area_to = 29 ", $horizonte) or die (mysql_error());
$rowENDO = mysql_fetch_row($resultENDO);

mysql_select_db($database_horizonte, $horizonte); //Para COLPO
$resultCOLPO = mysql_query("SELECT count(v.id_vc) from venta_conceptos v left join conceptos c on c.id_to = v.id_concepto_es where v.id_paciente_vc = $idP and c.id_tipo_concepto_to = 4 and v.estatus_vc = 5 and c.id_area_to = 85", $horizonte) or die (mysql_error());
$rowCOLPO = mysql_fetch_row($resultCOLPO);

mysql_select_db($database_horizonte, $horizonte); //Para SERVICIOS
$resultSERV = mysql_query("SELECT count(v.id_vc) from venta_conceptos v left join conceptos c on c.id_to = v.id_concepto_es where v.id_paciente_vc = $idP and c.id_tipo_concepto_to = 2 and v.estatus_vc = 3 ", $horizonte) or die (mysql_error());
$rowSERV = mysql_fetch_row($resultSERV);

mysql_select_db($database_horizonte, $horizonte); //Para la primer consulta
$resultCON = mysql_query("SELECT count(v.id_vc) from venta_conceptos v left join conceptos c on c.id_to = v.id_concepto_es where v.id_paciente_vc = $idP and c.id_tipo_concepto_to = 1 and v.estatus_vc = 6", $horizonte) or die (mysql_error());
$rowCON = mysql_fetch_row($resultCON);

echo $rowLab[0].';*-'.$rowUSG[0].';*-'.$rowIMG[0].';*-'.$rowENDO[0].';*-'.$rowCOLPO[0].';*-'.$rowSERV[0].';*-'.$rowCON[0];

//Cerrar conexión a la Base de Datos
mysql_close($horizonte);

?>