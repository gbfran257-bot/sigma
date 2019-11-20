<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $nombre = sqlValue(mb_strtoupper($_POST["nombreP"]), "text");
 $area = sqlValue($_POST["areaB"], "int");
 $unidadMedidaResultado = sqlValue($_POST["id_umBase"], "int");
 $equipo = sqlValue($_POST["equipoMu1"], "int");
 $idUsuario = sqlValue($_POST["idUsuarioP"], "int");
 $precioEstimado = sqlValue($_POST["precioP"], "double");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 $aleatorio = sqlValue($_POST["aleatorioB"], "text");

 mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO bases (usuario_reg_b, base_b, id_area_b, unidad_medida_r_b, precio_maquila_b, fecha_reg_b, aleatorio_b, id_equipo_b)";
 $sql.= "VALUES ($idUsuario, $nombre, $area, $unidadMedidaResultado, $precioEstimado, $now, $aleatorio, $equipo)";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) {
 	echo $sql;
 }else{ 
 	mysql_select_db($database_horizonte, $horizonte);
 	$result = mysql_query("SELECT id_b from bases order by id_b desc limit 1 ", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result); $idBase = sqlValue($row[0], "int");
	
	mysql_select_db($database_horizonte, $horizonte);
 	$sql1 = "UPDATE asignar_consumibles set id_base_ac = $idBase, temporal_ac = 0 where aleatorio_ac = $aleatorio";
	$update1 = mysql_query($sql1, $horizonte) or die (mysql_error());
	
	mysql_select_db($database_horizonte, $horizonte);
 	$sql2 = "UPDATE asignar_indicacion set id_base_ai = $idBase, temporal_ai = 0 where aleatorio_ai = $aleatorio";
	$update2 = mysql_query($sql2, $horizonte) or die (mysql_error());
	
	mysql_select_db($database_horizonte, $horizonte);
 	$sql3 = "UPDATE asignar_metodo set id_base_ame = $idBase, temporal_ame = 0 where aleatorio_ame = $aleatorio";
	$update3 = mysql_query($sql3, $horizonte) or die (mysql_error());
	
	mysql_select_db($database_horizonte, $horizonte);
 	$sql4 = "UPDATE asignar_muestra set id_base_am = $idBase, temporal_am = 0 where aleatorio_am = $aleatorio";
	$update4 = mysql_query($sql4, $horizonte) or die (mysql_error());
	
	mysql_select_db($database_horizonte, $horizonte);
 	$sql5 = "UPDATE asignar_valor_referencia set id_base_avr = $idBase, temporal_avr = 0 where aleatorio_avr = $aleatorio";
	$update5 = mysql_query($sql5, $horizonte) or die (mysql_error());
	
	echo 1;
 }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>