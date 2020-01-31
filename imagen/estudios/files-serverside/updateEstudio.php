<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $idEstudio = sqlValue($_POST["idEstudioE"], "int");
 $idUsuario = sqlValue($_POST["idUsuarioE"], "int");
 $nombre = sqlValue(mb_strtoupper($_POST["nombreE"]), "text");
 $precio = sqlValue($_POST["precioE"], "double");
 $precioU = sqlValue($_POST["precioUrgenciaE"], "double");

 $precioM = sqlValue($_POST["precioME"], "double");
 $precioMU = sqlValue($_POST["precioUrgenciaME"], "double");
 $precioH = sqlValue($_POST["precioHO"], "double");

 $idArea = sqlValue($_POST["areaE"], "int");
 $formato = sqlValue($_POST["input"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 $noTemp = sqlValue(date('Y-m-d-H-i-s'), "date");
 $precioMa = sqlValue($_POST["precioEM"], "double");
 $precioMau = sqlValue($_POST["precioUrgenciaM"], "double");
 $precioSu = sqlValue($_POST["precioES"], "double");
 $precioSuu = sqlValue($_POST["precioUrgenciaS"], "double");
 $dicom = sqlValue($_POST["dicom_i"], "int");
 
 //primero tenemos que saber si existe su tabulador, sino entnces escogemos el tabulador base
	$tabu = $_POST['miSucursalNS'].'_precio'; $resultT = mysql_query("SHOW COLUMNS FROM conceptos LIKE '$tabu' ");
	$existsT = (mysql_num_rows($resultT))?TRUE:FALSE;
	if($existsT) {
		$precio_nor = $_POST['miSucursalNS'].'_precio'; $precio_ur = $_POST['miSucursalNS'].'_precio_u';
		
		mysql_select_db($database_horizonte, $horizonte);
 		$sql = "UPDATE conceptos set concepto_to = $nombre, $precio_nor = $precio, $precio_ur = $precioU, id_area_to = $idArea, formato = $formato, precio_to = $precioMa, precio_urgencia_to = $precioMau, precio1_to = $precioSu, precio_urgencia1_to = $precioSuu, dicom = $dicom, precio_m = $precioM, precio_mu = $precioMU, precio_h = $precioH, costo_maquila_to = $precioMa, costo_maquila_u_to = $precioMau where id_to = $idEstudio";
	}else{
		mysql_select_db($database_horizonte, $horizonte);
 		$sql = "UPDATE conceptos set concepto_to = $nombre, precio_to = $precioMa, precio_urgencia_to = $precioMau, id_area_to = $idArea, formato = $formato, precio1_to = $precioSu, precio_urgencia1_to = $precioSuu, dicom = $dicom, precio_m = $precioM, precio_mu = $precioMU, precio_h = $precioH, costo_maquila_to = $precioMa, costo_maquila_u_to = $precioMau where id_to = $idEstudio";
	}
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) { echo $sql; }else{ echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>
