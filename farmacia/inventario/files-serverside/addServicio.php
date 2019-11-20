<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $idUsuario = sqlValue($_POST["idUsuarioS"], "int");
 $nombre = sqlValue($_POST["nombreS"], "text");
 $precio = sqlValue($_POST["precioS"], "double");
 $precioU = sqlValue($_POST["precioUrgenciaS"], "double");
 $idDepartamento = sqlValue($_POST["departamentoS"], "int");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");

 mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO conceptos (usuario_to, concepto_to, precio_to, precio_urgencia_to, fecha_to, id_departamento_to, id_tipo_concepto_to)";
 $sql.= "VALUES ($idUsuario, $nombre, $precio, $precioU, $now, $idDepartamento, 2)";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) {
 	echo $sql;
 }else{ 	
	echo 1;
 }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>