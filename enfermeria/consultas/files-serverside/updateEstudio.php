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
 $idP = sqlValue($_POST["idPacienteN"], "int");
 $formato = sqlValue($_POST["miDiagnostico"], "text");
  
 $sql = "UPDATE estudios SET clave_est = $clave, nombre_est = $nombre, precio_est = $precioF, precio_maquila_est = $precioM, depto_est = 1, area_est = $idArea, formato = $formato where id_est = $idP limit 1";

mysql_select_db($database_horizonte, $horizonte);
$insertar = mysql_query($sql, $horizonte);
 	
if (!$insertar) { echo $sql; }else { echo 1; }
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>