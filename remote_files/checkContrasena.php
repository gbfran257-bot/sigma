<?php
require("../Connections/horizonte.php");
require("../funciones/php/values.php");

$usuario = sqlValue($_POST["user"], "text");

mysql_select_db($database_horizonte, $horizonte);
$result1 = mysql_query("SELECT usuarioNuevo_u from usuarios where usuario_u = $usuario", $horizonte) or die (mysql_error());
$row1 = mysql_fetch_row($result1);

if($row1[0]==1){ $contrasena = strtoupper($_POST["contrasena"]);}
else{ $contrasena = $_POST["contrasena"];}

mysql_select_db($database_horizonte, $horizonte);
$result2 = mysql_query("SELECT contrasena_u from usuarios where usuario_u = $usuario", $horizonte) or die (mysql_error());
$row2 = mysql_fetch_row($result2);

$contrasena_hashed = $row2[0];

if(password_verify($contrasena, $contrasena_hashed)){ $entra = 1; }else{ $entra = 0;}

if($entra>0){ echo 'true'; }
else{ echo 'false'; }

mysql_close($horizonte);
?>