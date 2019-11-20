<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $idUsuario = sqlValue($_POST["idUsuarioS"], "int");
 $nombre = sqlValue($_POST["nombreS"], "text");
 $precio = sqlValue($_POST["precioS"], "double");
 $precioU = sqlValue($_POST["precioUrgenciaS"], "double");
 $idDepartamento = sqlValue(4, "int");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 $precioM = sqlValue($_POST["precioMe"], "double");
 $precioM1 = sqlValue($_POST["precioMe1"], "double");//$sucursal = sqlValue($_POST["miSucursalNS"], "int");
 
 //primero tenemos que saber si existe su tabulador, sino entnces escogemos el tabulador base
	$tabu = $_POST['miSucursalNS'].'_precio'; $resultT = mysql_query("SHOW COLUMNS FROM conceptos LIKE '$tabu' ");
	$existsT = (mysql_num_rows($resultT))?TRUE:FALSE;
	if($existsT) {
		$precio_nor = $_POST['miSucursalNS'].'_precio'; $precio_ur = $_POST['miSucursalNS'].'_precio_u';
		//$precio_nor_me = $_POST['miSucursalNS'].'_precio_mem'; $precio_ur_me = $_POST['miSucursalNS'].'_precio_mem_u';
	}else{
		$precio_nor = 'precio_to'; $precio_ur = 'precio_urgencia_to';
		//$precio_nor_me = 'precio_membrecia_to'; $precio_ur_me = 'precio_membrecia1';
	}

 mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO conceptos (usuario_to, concepto_to, $precio_nor, $precio_ur, fecha_to, id_departamento_to, id_tipo_concepto_to, id_area_to)";
 $sql.= "VALUES ($idUsuario, $nombre, $precio, $precioU, $now, 4, 2, 21)";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) { echo $sql; }else{ echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>