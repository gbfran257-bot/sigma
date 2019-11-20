<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 if(isset($_POST["aleatorio"])){ $aleatorio = sqlValue($_POST["aleatorio"], "text"); }else{$aleatorio = 0;}
 
 	mysql_select_db($database_horizonte, $horizonte);
 	$result = mysql_query("SELECT base_b, precio_maquila_b, id_area_b, unidad_medida_r_b, id_equipo_b, id_b from bases where aleatorio_b = $aleatorio ", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result);
	
	$idArea = sqlValue($row[2], "int");
	$idUM = sqlValue($row[3], "int");
	$idEquipo = sqlValue($row[4], "int");
	
	mysql_select_db($database_horizonte, $horizonte);
 	$result1 = mysql_query("SELECT nombre_a from areas where id_a = $idArea ", $horizonte) or die (mysql_error());
 	$row1 = mysql_fetch_row($result1);
	
	mysql_select_db($database_horizonte, $horizonte);
 	$result2 = mysql_query("SELECT unidad_un, abreviacion_un from unidades where id_un = $idUM ", $horizonte) or die (mysql_error());
 	$row2 = mysql_fetch_row($result2);
	
	mysql_select_db($database_horizonte, $horizonte);
 	$result3 = mysql_query("SELECT modelo_eq from catalogo_equipos where id_eq = $idEquipo ", $horizonte) or die (mysql_error());
 	$row3 = mysql_fetch_row($result3);
			 
 	$datos = $row[0]."{;]".$row[1]."{;]".$idArea."{;]".$idUM."{;]".$row3[0]."{;]".$row2[0]."{;]".$row[5]."{;]".$row2[1]."{;]".$row[3]."{;]".$row[4]."{;]".$row1[0]."{;]".$idEquipo;

echo $datos;
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>