<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

$clave = $_POST["telmovilP"];
$idE = sqlValue($_POST["idEs"], "int");

mysql_select_db($database_horizonte, $horizonte);
if($_POST["idEs"]!=NULL or $_POST["idEs"]!=''){
$result1 = mysql_query("SELECT COUNT(id_est) from estudios where clave_est = '$clave' and id_est != $idE ", $horizonte) or die (mysql_error());
$row1 = mysql_fetch_row($result1); $c=0;
}else{
	$result1 = mysql_query("SELECT COUNT(id_est) from estudios where clave_est = '$clave' ", $horizonte) or die (mysql_error());
	$row1 = mysql_fetch_row($result1); $c=1;
}
//si alguien que no sea este productor tiene el crup
if($row1[0]>0){ echo 'false'; }//si nadie lo tiene
else{ echo 'true'; }

mysql_close($horizonte);
?>