<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idD = sqlValue($_POST["idD"], "int");
mysql_select_db($database_horizonte, $horizonte);
$suc = "SELECT aleatorio_do from documentos where id_do = $idD";
$query = mysql_query($suc, $horizonte) or die (mysql_error());
$sucursal =  mysql_fetch_row($query);
 
mysql_select_db($database_horizonte, $horizonte);
$sql = "SELECT num_suc_do from documentos where aleatorio_do = '$sucursal[0]' AND que_es_do = 'DOCUMENTO'";
$update = mysql_query($sql, $horizonte) or die (mysql_error());
$num = array();
$cot_num = 0;
$datos = '';
while ($fila = mysql_fetch_assoc($update)) {
   $num[$cot_num] = $fila['num_suc_do'];
   $datos.= $datos.';-}{'.$num[$cot_num];
   $cot_num++;
}
// $datos = $num[0].';-}{'.$num[1].';-}{'.$num[2].';-}{'.$num[3].';-}{'.$num[4];
if (!$update) {
 	echo $sql;
 }else{ 
    echo $datos;
 }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>