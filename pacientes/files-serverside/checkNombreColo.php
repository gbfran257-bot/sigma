<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$cp_n = sqlValue($_POST["cp_n"], "text");
$nombre_nc = sqlValue($_POST["colonia"], "text");
$municipio = sqlValue($_POST["municipio"], "int");

mysql_select_db($database_horizonte, $horizonte);

$result2 = mysql_query("SELECT d_estado, d_municipio from mexico where id_mx = $municipio limit 1", $horizonte) or die (mysql_error());
$row2 = mysql_fetch_row($result2); $estado1 = sqlValue($row2[0], "text"); $municipio1 = sqlValue($row2[1], "text");

mysql_select_db($database_horizonte, $horizonte);

$result1 = mysql_query("SELECT COUNT(id_mx) from mexico where d_codigo = $cp_n and d_estado = $estado1 and d_municipio = $municipio1 and d_asenta = $nombre_nc ", $horizonte) or die (mysql_error());
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