<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $idS = sqlValue($_POST["idServicio"], "int");
 $idUsuario = sqlValue($_POST["idUsuarioS"], "int");
 $nombre = sqlValue($_POST["nombreS"], "text");
 $precio = sqlValue($_POST["precioS"], "double");
 $precioU = sqlValue($_POST["precioUrgenciaS"], "double");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 //$precioM = sqlValue($_POST["precioMe"], "double"); $precioM1 = sqlValue($_POST["precioMe1"], "double");
 
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
   
 $sql = "UPDATE conceptos SET concepto_to = $nombre, $precio_nor = $precio, $precio_ur = $precioU where id_to = $idS limit 1";

mysql_select_db($database_horizonte, $horizonte);
$insertar = mysql_query($sql, $horizonte);
 	
if (!$insertar) { echo $sql; }else { echo 1; }
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>