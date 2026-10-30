<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $idUsuario = sqlValue($_POST["idUsuarioP"], "int");
 $nombre = sqlValue($_POST["nombreP"], "text");
 //$idDepartamento = sqlValue($_POST["sexoP"], "int");
 $clave = sqlValue($_POST["telmovilP"], "text");
 $precioM = sqlValue($_POST["telparticularP"], "double");
 $idArea = sqlValue($_POST["areasE"], "int");
 $precioF = sqlValue($_POST["edadP"], "double");
 $formato = sqlValue($_POST["miDiagnostico"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");

 mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO estudios (usuario_est, nombre_est, precio_est, precio_maquila_est, depto_est, area_est, fecha_registro_est, clave_est, habilitado_est, formato)";
 $sql.= "VALUES ($idUsuario, $nombre, $precioF, $precioM, 1, $idArea, $now, $clave, 1, $formato)";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) {
 	echo 'bad';
 }else{ 
 	mysql_select_db($database_horizonte, $horizonte);
 	$result = mysql_query("SELECT id_est from estudios order by id_est desc limit 1 ", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result);
	
	echo $row[0];

 }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>