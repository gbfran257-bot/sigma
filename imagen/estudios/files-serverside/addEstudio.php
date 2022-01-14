<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $idUsuario = sqlValue($_POST["idUsuarioE"], "int");
 $linea = sqlValue($_POST["linea_img"], "text");
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
 $formato = sqlValue($_POST["input"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 $noTemp = sqlValue(date('Y-m-d-H-i-s'), "date");
 $dicom = sqlValue($_POST["dicom_i"], "int");

 $costoProduccion = sqlValue($_POST["costoproduccion"], "int");
 $MotivoCostoProduccion = sqlValue(mb_strtoupper($_POST["motivocostoproduccion"]), "text");
 
 //primero tenemos que saber si existe su tabulador, sino entnces escogemos el tabulador base
	$tabu = $_POST['miSucursalNS'].'_precio'; $resultT = mysql_query("SHOW COLUMNS FROM conceptos LIKE '$tabu' ");
	$existsT = (mysql_num_rows($resultT))?TRUE:FALSE;
	if($existsT) {
		$precio_nor = $_POST['miSucursalNS'].'_precio'; $precio_ur = $_POST['miSucursalNS'].'_precio_u';
		
		mysql_select_db($database_horizonte, $horizonte);
 		$sql = "INSERT INTO conceptos (usuario_to, concepto_to, $precio_nor, $precio_ur, id_area_to, formato, fecha_to, id_departamento_to, id_tipo_concepto_to, precio_to, precio_urgencia_to, precio1_to, precio_urgencia1_to, aleatorio_c, dicom, precio_m, precio_mu, precio_h, costo_maquila_to, costo_maquila_u_to, c_costo, motivo_costo, linea_c)";
 		$sql.= "VALUES ($idUsuario, $nombre, $precio, $precioU, $idArea, $formato, $now, 2, 4, $precio, $precioU, $precioS, $precioSU, $noTemp, $dicom, $precioM, $precioMU, $precioH, $precioMa, $precioMaU, $costoProduccion, $MotivoCostoProduccion, $linea)";
	}else{
		mysql_select_db($database_horizonte, $horizonte);
 		$sql = "INSERT INTO conceptos (usuario_to, concepto_to, precio_to, precio_urgencia_to, id_area_to, formato, fecha_to, id_departamento_to, id_tipo_concepto_to, precio1_to, precio_urgencia1_to, aleatorio_c, dicom, precio_m, precio_mu, precio_h, costo_maquila_to, costo_maquila_u_to, c_costo, motivo_costo, linea_c)";
 		$sql.= "VALUES ($idUsuario, $nombre, $precio, $precioU, $idArea, $formato, $now, 2, 4, $precioS, $precioSU, $noTemp, $dicom, $precioM, $precioMU, $precioH, $precioMa, $precioMaU, $costoProduccion, $MotivoCostoProduccion, $linea)";
	}

 /*mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO conceptos (usuario_to, concepto_to, precio_to, precio_urgencia_to, id_area_to, formato, fecha_to, id_departamento_to, id_tipo_concepto_to, precio1_to, precio_urgencia1_to, aleatorio_c, dicom)";
 $sql.= "VALUES ($idUsuario, $nombre, $precio, $precioU, $idArea, $formato, $now, 2, 4, $precio, $precioU, $noTemp, $dicom)";*/
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
 if (!$update) { echo $sql; }else{ echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
	
 //Cuando creamos un estudio, sólo se guarda en conceptos, cuando hacemos una actualización del mismo es cuando lo guardamos también en la tabla de sucursal-concepto, y ahí si debemos escoger la sucursal, y se puede guardar un registro en esta tabla por cada sucursal con cada concepto.
?>
