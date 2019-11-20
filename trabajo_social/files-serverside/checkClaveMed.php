<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$clave = sqlValue($_POST["clave"], "text");
//$id_dx = sqlValue($_GET["id_dx"], "int");

mysql_select_db($database_horizonte, $horizonte);

$result1 = mysql_query("SELECT COUNT(id_med) from medicamentos where clave_med = $clave ", $horizonte) or die (mysql_error());
$row1 = mysql_fetch_row($result1);

//si alguien que no sea este usuario tiene el username
if($row1[0]>0){
	echo 'false';
}//si nadie lo tiene
else{
	echo 'true';
}

mysql_close($horizonte);
?>