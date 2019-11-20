<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $idUsuario = sqlValue($_POST["idUsuarioE"], "int");
 $nombre = sqlValue(mb_strtoupper($_POST["nombreE"]), "text");
 $precio = sqlValue($_POST["precioE"], "double");
 $precioU = sqlValue($_POST["precioUrgenciaE"], "double");
 $formato = sqlValue($_POST["input"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 $noTemp = sqlValue(date('Y-m-d-H-i-s'), "date");
 
 //primero tenemos que saber si existe su tabulador, sino entnces escogemos el tabulador base
	$tabu = $_POST['miSucursalNS'].'_precio'; $resultT = mysql_query("SHOW COLUMNS FROM conceptos LIKE '$tabu' ");
	$existsT = (mysql_num_rows($resultT))?TRUE:FALSE;
	if($existsT) {
		$precio_nor = $_POST['miSucursalNS'].'_precio'; $precio_ur = $_POST['miSucursalNS'].'_precio_u';
		
		mysql_select_db($database_horizonte, $horizonte);
 		$sql = "INSERT INTO conceptos (usuario_to, concepto_to, $precio_nor, $precio_ur, formato, fecha_to, id_departamento_to, id_tipo_concepto_to, precio_to, precio_urgencia_to, precio1_to, precio_urgencia1_to, aleatorio_c, id_area_to)";
 		$sql.= "VALUES ($idUsuario, $nombre, $precio, $precioU, $formato, $now, 4, 2, $precio, $precioU, $precio, $precioU, $noTemp, 21)";
 
	}else{
		$precio_nor = 'precio_to'; $precio_ur = 'precio_urgencia_to';
		
		mysql_select_db($database_horizonte, $horizonte);
 		$sql = "INSERT INTO conceptos (usuario_to, concepto_to, $precio_nor, $precio_ur, formato, fecha_to, id_departamento_to, id_tipo_concepto_to, precio1_to, precio_urgencia1_to, aleatorio_c, id_area_to)";
 		$sql.= "VALUES ($idUsuario, $nombre, $precio, $precioU, $formato, $now, 4, 2, $precio, $precioU, $noTemp, 21)";
	}
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) { echo $sql; }else{ echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>