<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idP = sqlValue($_POST["idP"], "int");
 $idE = sqlValue($_POST["idE"], "int"); //en venta de conceptos
 
mysql_select_db($database_horizonte, $horizonte);
$result1 = mysql_query("SELECT nombre_p, apaterno_p, amaterno_p from pacientes where id_p = $idP ", $horizonte) or die (mysql_error());
$row1 = mysql_fetch_row($result1);

mysql_select_db($database_horizonte, $horizonte);
$result2 = mysql_query("SELECT referencia_vc, id_concepto_es, nota_radiologo_vc from venta_conceptos where id_vc = $idE ", $horizonte) or die (mysql_error());
$row2 = mysql_fetch_row($result2);
$claveE = sqlValue($row2[1], "text");
$ref = sqlValue($row2[0], "text");

mysql_select_db($database_horizonte, $horizonte);
$result3 = mysql_query("SELECT concepto_to, id_area_to from conceptos where id_to = $claveE ", $horizonte) or die (mysql_error());
$row3 = mysql_fetch_row($result3);
$areaE = sqlValue($row3[1], "int");

mysql_select_db($database_horizonte, $horizonte);
$result4 = mysql_query("SELECT nombre_a from areas where id_a = $areaE ", $horizonte) or die (mysql_error());
$row4 = mysql_fetch_row($result4);

mysql_select_db($database_horizonte, $horizonte);
$result5 = mysql_query("SELECT observaciones_l_ov from orden_venta where referencia_ov = $ref ", $horizonte) or die (mysql_error());
$row5 = mysql_fetch_row($result5);

mysql_select_db($database_horizonte, $horizonte);
$result6 = mysql_query("SELECT count(id_vc) from venta_conceptos where estatus_vc = 1 and referencia_vc = $ref and tipo_concepto_vc = 3", $horizonte) or die (mysql_error());
$row6 = mysql_fetch_row($result6);
  
echo $row1[0].' '.$row1[1].' '.$row1[2].'*}'.$row2[0].'*}'.$row3[0].'*}'.$row4[0].'*}'.$row5[0].'*}'.$row6[0].'*}'.$row4[0].'*}'.$areaE.'*}'.$row2[2];
//Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>