<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $idUsuario = sqlValue($_POST["idUsuarioE"], "int");
 $nombre = sqlValue(mb_strtoupper($_POST["nombreE"]), "text");
 $precio = sqlValue($_POST["precioE"], "double");
 $precioU = sqlValue($_POST["precioUrgenciaE"], "double");
 $precioM = sqlValue($_POST["precioME"], "double");
 $precioMU = sqlValue($_POST["precioUrgenciaME"], "double");
 $precioH = sqlValue($_POST["precioHO"], "double");
 $precioS = sqlValue($_POST["precioES"], "double");
 $precioSU = sqlValue($_POST["precioUrgenciaS"], "double");
 $precioMa = sqlValue($_POST["precioEM"], "double");
 $precioMaU = sqlValue($_POST["precioUrgenciaM"], "double");
 $idArea = sqlValue($_POST["areaE"], "int");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 $noTemp = sqlValue($_POST["aleatorioB"], "text");
 $dEntrega = sqlValue($_POST["dEntregaE"], "int");
 $formato = sqlValue($_POST["input"], "text");
 
 //primero tenemos que saber si existe su tabulador, sino entnces escogemos el tabulador base
	$tabu = $_POST['miSucursalNS'].'_precio'; $resultT = mysql_query("SHOW COLUMNS FROM conceptos LIKE '$tabu' ");
	$existsT = (mysql_num_rows($resultT))?TRUE:FALSE;
	if($existsT) {
		$precio_nor = $_POST['miSucursalNS'].'_precio'; $precio_ur = $_POST['miSucursalNS'].'_precio_u';
		
		mysql_select_db($database_horizonte, $horizonte);
 		$sql = "INSERT INTO conceptos (usuario_to, concepto_to, $precio_nor, $precio_ur, id_area_to, formato, fecha_to, id_departamento_to, id_tipo_concepto_to, precio_to, precio_urgencia_to, aleatorio_c, dias_entrega_to, precio_m, precio_mu, precio_h, costo_maquila_to, costo_maquila_u_to)";
 		$sql.= "VALUES ($idUsuario, $nombre, $precioMa, $precioMaU, $idArea, $formato, $now, 1, 3, $precio, $precioU, $noTemp, $dEntrega, $precioM, $precioMU, $precioH, $precioM, $precioMU)"; 
	}else{
		$precio_nor = 'precio_to'; $precio_ur = 'precio_urgencia_to';
		
		mysql_select_db($database_horizonte, $horizonte);
 		$sql = "INSERT INTO conceptos (usuario_to, concepto_to, precio_to, precio_urgencia_to, id_area_to, formato, fecha_to, id_departamento_to, id_tipo_concepto_to, aleatorio_c, dias_entrega_to, precio_m, precio_mu, precio_h, costo_maquila_to, costo_maquila_u_to)";
 		$sql.= "VALUES ($idUsuario, $nombre, $precio, $precioU, $idArea, $formato, $now, 1, 3, $noTemp, $dEntrega, $precioM, $precioMU, $precioH, $precioM, $precioMU)";		
	}
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
 if (!$update) { echo $sql; }else{
	mysql_select_db($database_horizonte, $horizonte);
 	$result = mysql_query("SELECT id_to from conceptos order by id_to desc limit 1 ", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result); $idBase = sqlValue($row[0], "int");
	 
	mysql_select_db($database_horizonte, $horizonte);
 	$sql4 = "UPDATE asignar_muestra set id_base_am = $idBase, temporal_am = 0 where aleatorio_am = $noTemp";
	$update4 = mysql_query($sql4, $horizonte) or die (mysql_error());
	 
	mysql_select_db($database_horizonte, $horizonte);
 	$sql3 = "UPDATE asignar_metodo set id_base_ame = $idBase, temporal_ame = 0 where aleatorio_ame = $noTemp";
	$update3 = mysql_query($sql3, $horizonte) or die (mysql_error());
	 
	echo 1;
 }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>
