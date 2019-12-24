<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$idE=sqlValue($_POST["idE"],"int"); //en VC

mysql_select_db($database_horizonte, $horizonte);
$result0 = mysql_query("SELECT referencia_vc from venta_conceptos where id_vc = $idE limit 1", $horizonte) or die (mysql_error());
$row0 = mysql_fetch_row($result0); $referencia_ov = sqlValue($row0[0], "text");

mysql_select_db($database_horizonte, $horizonte);
$result2 = mysql_query("SELECT s.id_su, s.no_temp_su from orden_venta o left join sucursales s on s.id_su = o.sucursal_ov where o.referencia_ov = $referencia_ov ", $horizonte) or die (mysql_error());
$row2 = mysql_fetch_row($result2); $id_suc = sqlValue($row2[0], "int"); $ale_suc = sqlValue($row2[1], "text");
 
mysql_select_db($database_horizonte, $horizonte);
$resultE=mysql_query("SELECT count(id_do) from documentos where aleatorio_do = $ale_suc and tipo_quien_do = 2 and nombre_do = 'ENCABEZADO' and que_es_do = 'MEMBRETE NOTA MEDICA'",$horizonte) or die (mysql_error());
$rowE = mysql_fetch_row($resultE);

mysql_select_db($database_horizonte, $horizonte);
$resultP=mysql_query("SELECT count(id_do) from documentos where aleatorio_do = $ale_suc and tipo_quien_do = 2 and nombre_do = 'PIE' and que_es_do = 'MEMBRETE NOTA MEDICA'",$horizonte) or die (mysql_error());
$rowP = mysql_fetch_row($resultP);

mysql_select_db($database_horizonte, $horizonte);
$resultE1=mysql_query("SELECT count(id_do) from documentos where aleatorio_do = $ale_suc and tipo_quien_do = 2 and nombre_do = 'ENCABEZADO' and que_es_do = 'MEMBRETE RECETA MEDICA'",$horizonte) or die (mysql_error());
$rowE1 = mysql_fetch_row($resultE1);

mysql_select_db($database_horizonte, $horizonte);
$resultP1=mysql_query("SELECT count(id_do) from documentos where aleatorio_do = $ale_suc and tipo_quien_do = 2 and nombre_do = 'PIE' and que_es_do = 'MEMBRETE RECETA MEDICA'",$horizonte) or die (mysql_error());
$rowP1 = mysql_fetch_row($resultP1);

if($rowE[0]>0 and $rowP[0]>0){$ep = 1;}else{$ep = 0;}

if($rowE1[0]>0 and $rowP1[0]>0){$ep1 = 1;}else{$ep1 = 0;}

echo $ep.';'.$ep1;

//Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>