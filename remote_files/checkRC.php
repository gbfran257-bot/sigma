<?php
require("../Connections/horizonte.php");
require("../funciones/php/values.php");

$usuario = sqlValue($_POST["usuarioRC"], "text");
$email = sqlValue($_POST["emailRC"], "text");
$opc = 0;

mysql_select_db($database_horizonte, $horizonte);

$result1 = mysql_query("SELECT COUNT(id_u) from usuarios where usuario_u = $usuario and email_u = $email ", $horizonte) or die (mysql_error());
$row1 = mysql_fetch_row($result1);

if($row1[0]>0){ //por lo menos existe la cuenta
	$opc = 1;
	
	$result2 = mysql_query("SELECT validado_u from usuarios where usuario_u = $usuario and email_u = $email ", $horizonte) or die (mysql_error());
	$row2 = mysql_fetch_row($result2);
	if($row2[0]==0){ $opc = 2; }
	
	$result3 = mysql_query("SELECT activo_u from usuarios where usuario_u = $usuario and email_u = $email ", $horizonte) or die (mysql_error());
	$row3 = mysql_fetch_row($result3);
	if($row3[0]==0){ $opc = 3; }
	
}else{ //no existe la cuenta
	$opc = 5;
}

echo $opc;

mysql_close($horizonte);
?>