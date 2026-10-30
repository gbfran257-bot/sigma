<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$clave = '("'.$_POST["claveC"].'")';
$idS = sqlValue($_POST["idEs"], "int");

mysql_select_db($database_horizonte, $horizonte);
if($_POST["idEs"]!=NULL or $_POST["idEs"]!=''){
$result1 = mysql_query("SELECT COUNT(id_su) from seguros where clave_su in $clave and id_su != $idS ", $horizonte) or die (mysql_error());
$row1 = mysql_fetch_row($result1); $c=0;
}else{
	$result1 = mysql_query("SELECT COUNT(id_su) from seguros where clave_su in $clave ", $horizonte) or die (mysql_error());
	$row1 = mysql_fetch_row($result1); $c=1;
}
//si alguien que no sea este productor tiene el crup
if($row1[0]>0){ echo 'false'; }//si nadie lo tiene
else{ echo 'true'; }

mysql_close($horizonte);
?>