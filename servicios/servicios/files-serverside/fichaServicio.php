<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $idS = sqlValue($_POST["idS"], "int");
 $idSucu = sqlValue($_POST["idSucursal"], "int");
 
 //primero tenemos que saber si existe su tabulador, sino entnces escogemos el tabulador base
	$tabu = $_POST['idSucursal'].'_precio'; $resultT = mysql_query("SHOW COLUMNS FROM conceptos LIKE '$tabu' ");
	$existsT = (mysql_num_rows($resultT))?TRUE:FALSE;
	if($existsT) {
		$precio_nor = $_POST['idSucursal'].'_precio'; $precio_ur = $_POST['idSucursal'].'_precio_u';
	}else{
		$precio_nor = 'precio_to'; $precio_ur = 'precio_urgencia_to';
	}
 
 	mysql_select_db($database_horizonte, $horizonte);
 	$result = mysql_query("SELECT concepto_to, $precio_nor, $precio_ur, $precio_nor, $precio_nor from conceptos where id_to = $idS ", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result);
			 
 	$datos = $row[0]."*}".$row[1]."*}".$row[2]."*}".$row[3]."*}".$row[4];

echo $datos;
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>