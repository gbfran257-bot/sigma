<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $idUsuario = sqlValue($_POST["idUsuarioE"], "int");
 $nombre = sqlValue($_POST["nombreE"], "text");
 $precio = sqlValue($_POST["precioE"], "double");
 $precioU = sqlValue($_POST["precioUrgenciaE"], "double");
 $idArea = sqlValue($_POST["areaE"], "int");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 $noTemp = sqlValue($_POST["aleatorioB"], "text");
 $dEntrega = sqlValue($_POST["dEntregaE"], "int");
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

 mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO conceptos (usuario_to, concepto_to, $precio_nor, $precio_ur, id_area_to, fecha_to, id_departamento_to, id_tipo_concepto_to, aleatorio_c, dias_entrega_to)";
 $sql.= "VALUES ($idUsuario, $nombre, $precio, $precioU, $idArea, $now, 1, 3, $noTemp, $dEntrega)";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) {
 	echo $sql;
 }else{ 
 	mysql_select_db($database_horizonte, $horizonte); 
	$resultC = mysql_query("SELECT max(id_to) from conceptos limit 1 ", $horizonte) or die (mysql_error());
	$rowC = mysql_fetch_row($resultC);
	
	mysql_select_db($database_horizonte, $horizonte); 
	$resultC1 = mysql_query("SELECT aleatorio_c from conceptos where id_to = $rowC[0] limit 1 ",$horizonte) or die (mysql_error());
	$rowC1 = mysql_fetch_row($resultC1); $ale = sqlValue($rowC1[0], "text");
	
	$sqlF = "UPDATE asignar_bases SET id_estudio_ab = $rowC[0], aleatorio_ab = $ale where aleatorio_ab = $noTemp";

	mysql_select_db($database_horizonte, $horizonte);
	$insertar = mysql_query($sqlF, $horizonte);
		
	if (!$insertar) { echo $sqlF; }else { echo 1; }
 }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>