<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idUs = sqlValue($_POST["idUs"], "int"); //usuario a reiniciar
 $idU = sqlValue($_POST["idU"], "int");
 
 mysql_select_db($database_horizonte, $horizonte);
 $resultF = mysql_query("SELECT usuario_u from usuarios where id_u = $idUs limit 1 ", $horizonte) or die (mysql_error());
 $rowF = mysql_fetch_row($resultF);
 
 $hashed_password = sqlValue(password_hash($rowF[0], PASSWORD_DEFAULT), "text");
 
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "UPDATE usuarios SET contrasena_u = $hashed_password where id_u = $idUs limit 1";  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) { echo $sql; }else { echo 1; }
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>