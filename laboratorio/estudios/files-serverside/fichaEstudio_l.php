<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $idE = sqlValue($_POST["idE"], "int");
 
 //primero tenemos que saber si existe su tabulador, sino entnces escogemos el tabulador base
	$tabu = $_POST['idSucursal'].'_precio'; $resultT = mysql_query("SHOW COLUMNS FROM conceptos LIKE '$tabu' ");
	$existsT = (mysql_num_rows($resultT))?TRUE:FALSE;
	if($existsT) {
		$precio_nor = $_POST['idSucursal'].'_precio'; $precio_ur = $_POST['idSucursal'].'_precio_u';
	}else{
		$precio_nor = 'precio_to'; $precio_ur = 'precio_urgencia_to';
	} 
 
 	mysql_select_db($database_horizonte, $horizonte);
 	$result = mysql_query("SELECT concepto_to, id_area_to, $precio_nor, $precio_ur, formato, precio_to, precio_urgencia_to, precio_to, precio_urgencia_to, dias_entrega_to, precio_m, precio_mu, precio_h, costo_maquila_to, costo_maquila_u_to, c_costo, motivo_costo from conceptos where id_to = $idE ", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result);

 	$datos = $row[0]."*}".$row[1]."*}".$row[2]."*}".$row[3]."*}".$row[4]."*}".$row[5]."*}".$row[6]."*}".$row[7]."*}".$row[8]."*}".$row[9]."*}".$row[10]."*}".$row[11]."*}".$row[12]."*}".$row[13]."*}".$row[14]."*}".$row[15]."*}".$row[16];

echo $datos;
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>
