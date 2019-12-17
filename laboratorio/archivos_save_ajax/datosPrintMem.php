<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$idE=sqlValue($_POST["idE"],"int"); //en VC
$id_s=sqlValue($_POST["id_s"],"int");
 
mysql_select_db($database_horizonte, $horizonte);
$result2 = mysql_query("SELECT s.id_su, s.no_temp_su from sucursales s where s.id_su = $id_s ", $horizonte) or die (mysql_error());
$row2 = mysql_fetch_row($result2); $id_suc = sqlValue($row2[0], "int"); $ale_suc = sqlValue($row2[1], "text");
 
mysql_select_db($database_horizonte, $horizonte);
$resultE=mysql_query("SELECT count(id_do) from documentos where aleatorio_do = $ale_suc and tipo_quien_do = 2 and nombre_do = 'ENCABEZADO' and que_es_do = 'MEMBRETE RESULTADOS LABORATORIO'",$horizonte) or die (mysql_error());
$rowE = mysql_fetch_row($resultE);

mysql_select_db($database_horizonte, $horizonte);
$resultP=mysql_query("SELECT count(id_do) from documentos where aleatorio_do = $ale_suc and tipo_quien_do = 2 and nombre_do = 'PIE' and que_es_do = 'MEMBRETE RESULTADOS LABORATORIO'",$horizonte) or die (mysql_error());
$rowP = mysql_fetch_row($resultP);

if($rowE[0]>0 and $rowP[0]>0){$ep = 1;}else{$ep = 0;}

echo $ep;

//Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>