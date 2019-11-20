<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

	$idC = sqlValue($_POST["idCx"], "int");
	
	mysql_select_db($database_horizonte, $horizonte);
	$resultC=mysql_query("SELECT id_signosv_vc from venta_conceptos where id_vc = $idC limit 1",$horizonte) or die (mysql_error());
 	$rowC = mysql_fetch_row($resultC); $idSV = sqlValue($rowC[0], "int");
	
	mysql_select_db($database_horizonte, $horizonte);
	$result1 = mysql_query("SELECT peso_sv,talla_sv, imc_sv, cintura_sv, t_sv, a_sv, fr_sv, fc_sv, temperatura_sv, notas_sv, DATE_FORMAT(fecha_sv,'%d/%c/%Y %H:%i:%s'), id_usuario_sv from signos_vitales where id_sv = $idSV limit 1", $horizonte) or die (mysql_error());
 	$row1 = mysql_fetch_row($result1); $id_u_sv = sqlValue($row1[11], "int");
	
	mysql_select_db($database_horizonte, $horizonte);
	$result2 = mysql_query("SELECT usuario_u from usuarios where id_u = $id_u_sv limit 1", $horizonte) or die (mysql_error());
 	$row2 = mysql_fetch_row($result2);
		
	$datos = $row1[0].';*-'.$row1[1].';*-'.$row1[2].';*-'.$row1[3].';*-'.$row1[4].';*-'.$row1[5].';*-'.$row1[6].';*-'.$row1[7].';*-'.$row1[8].';*-'.$row1[9].';*-'.$row1[10].';*-'.$row2[0];
	
	echo $datos;
 	//Cerrar conexión a la Base de Datos
 	mysql_close($horizonte);
?>