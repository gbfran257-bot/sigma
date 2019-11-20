<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$nombreM = sqlValue($_POST["nombreM"], "text");
$estado = sqlValue($_POST["estado"], "int");

mysql_select_db($database_horizonte, $horizonte);

$result2 = mysql_query("SELECT d_estado from mexico where id_mx = $estado limit 1", $horizonte) or die (mysql_error());
$row2 = mysql_fetch_row($result2); $estado1 = sqlValue($row2[0], "text");

mysql_select_db($database_horizonte, $horizonte);

$result1 = mysql_query("SELECT COUNT(id_mx) from mexico where d_municipio = $nombreM and d_estado = $estado1 ", $horizonte) or die (mysql_error());
$row1 = mysql_fetch_row($result1);

//si alguien que no sea este usuario tiene la clave
if($row1[0]>0){
	echo 'false';
}//si nadie lo tiene
else{
	echo 'true';
}

mysql_close($horizonte);
?>