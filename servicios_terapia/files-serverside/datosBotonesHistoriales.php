<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$idP = sqlValue($_POST["idP"], "int");

mysql_select_db($database_horizonte, $horizonte);// para lab
$resultLab = mysql_query("SELECT count(v.id_vc) from venta_conceptos v left join conceptos c on c.id_to = v.id_concepto_es where v.id_paciente_vc = $idP and v.temporal_vc = 0 and v.tipo_concepto_vc = 3 and v.estatus_vc > 6 and c.concepto_to!='' ", $horizonte) or die (mysql_error());
$rowLab = mysql_fetch_row($resultLab);

mysql_select_db($database_horizonte, $horizonte); //Para USG
$resultUSG = mysql_query("SELECT count(id_vc) from venta_conceptos left join conceptos on id_to = id_concepto_es where id_paciente_vc = $idP and temporal_vc = 0 and tipo_concepto_vc = 4 and estatus_vc = 5 and concepto_to != '' and area_vc = 58 ", $horizonte) or die (mysql_error());
$rowUSG = mysql_fetch_row($resultUSG);

mysql_select_db($database_horizonte, $horizonte); //Para IMG
$resultIMG = mysql_query("SELECT count(id_vc) from venta_conceptos left join conceptos on id_to = id_concepto_es where id_paciente_vc = $idP and tipo_concepto_vc = 4 and estatus_vc = 5 and concepto_to != '' and area_vc not in (29,58,85) and temporal_vc = 0 ", $horizonte) or die (mysql_error());
$rowIMG = mysql_fetch_row($resultIMG);

mysql_select_db($database_horizonte, $horizonte); //Para ENDO
$resultENDO = mysql_query("SELECT count(id_vc) from venta_conceptos left join conceptos on id_to = id_concepto_es where id_paciente_vc = $idP and tipo_concepto_vc = 4 and estatus_vc = 5 and concepto_to != '' and area_vc = 29 and temporal_vc = 0 ", $horizonte) or die (mysql_error());
$rowENDO = mysql_fetch_row($resultENDO);

mysql_select_db($database_horizonte, $horizonte); //Para COLPO
$resultCOLPO = mysql_query("SELECT count(id_vc) from venta_conceptos left join conceptos on id_to = id_concepto_es where id_paciente_vc = $idP and tipo_concepto_vc = 4 and estatus_vc = 5 and concepto_to != '' and area_vc = 85 and temporal_vc = 0 ", $horizonte) or die (mysql_error());
$rowCOLPO = mysql_fetch_row($resultCOLPO);

mysql_select_db($database_horizonte, $horizonte); //Para SERVICIOS
$resultSERV = mysql_query("SELECT count(id_vc) from venta_conceptos left join conceptos on id_to = id_concepto_es where id_paciente_vc = $idP and tipo_concepto_vc = 2 and estatus_vc = 3 and concepto_to != '' ", $horizonte) or die (mysql_error());
$rowSERV = mysql_fetch_row($resultSERV);

mysql_select_db($database_horizonte, $horizonte); //Para la primer consulta
$resultCON = mysql_query("SELECT count(id_vc) from venta_conceptos left join conceptos on id_to = id_concepto_es where id_paciente_vc = $idP and tipo_concepto_vc = 1 and estatus_vc = 6 and concepto_to != '' and temporal_vc = 0 ", $horizonte) or die (mysql_error());
$rowCON = mysql_fetch_row($resultCON);

echo $rowLab[0].';*-'.$rowUSG[0].';*-'.$rowIMG[0].';*-'.$rowENDO[0].';*-'.$rowCOLPO[0].';*-'.$rowSERV[0].';*-'.$rowCON[0];

//Cerrar conexión a la Base de Datos
mysql_close($horizonte);

?>