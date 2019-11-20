<?php
require("../Connections/horizonte.php");
require("../funciones/php/values.php");

$usuario = $_POST["usuario"];

mysql_select_db($database_horizonte, $horizonte);
$result1 = mysql_query("SELECT COUNT(id_u) from usuarios where usuario_u = '$usuario' ", $horizonte) or die (mysql_error());
$row1 = mysql_fetch_row($result1);

//si alguien que no sea este productor tiene el crup
if($row1[0]>0){
	echo 'true';
}//si nadie lo tiene
else{
	echo 'false';
}

mysql_close($horizonte);
?>