<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$user = sqlValue($_POST["user"], "text");
//$idU = sqlValue($_GET["idU"], "int");

mysql_select_db($database_horizonte, $horizonte);

$result1 = mysql_query("SELECT COUNT(id_u) from usuarios where usuario_u = $user ", $horizonte) or die (mysql_error());
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