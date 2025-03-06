<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $id = sqlValue($_POST["idPacienteN"], "int");
 $idUsuario = sqlValue($_POST["idUsuarioP"], "int");
 $nombre = sqlValue($_POST["nombreP"], "text");
 $area = sqlValue($_POST["areaB"], "int");
 $unidadMedidaResultado = sqlValue($_POST["id_umBase"], "int");
 $precioEstimado = sqlValue($_POST["precioP"], "double"); //esta variable ya no se usa, no estaba haciendo la suma de consumibles.
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 $aleatorio = sqlValue($_POST["aleatorioB"], "text");
 if(isset($_POST["equipoMu1"])){
	 $equipo = sqlValue($_POST["equipoMu1"], "int");
 }else{$equipo = 'NULL';}

//Verificamos si la base tiene consumibles agregados
mysql_select_db($database_horizonte, $horizonte);
$qry_contar_consumibles = mysql_query("SELECT COUNT(id_ac) FROM asignar_consumibles WHERE precio_ac IS NOT NULL AND aleatorio_ac = $aleatorio", $horizonte) or die (mysql_error());
$numero_consumibles = mysql_fetch_row($qry_contar_consumibles);
$count_consumibles = $numero_consumibles[0];

if($count_consumibles == 0){
	$suma_consumibles = 0;
}else{
	//Obtenemos la suma de los consumibles que estan asociados a la base
	mysql_select_db($database_horizonte, $horizonte);
	$qry_sumar_consumibles = mysql_query("SELECT SUM(precio_ac) FROM asignar_consumibles WHERE aleatorio_ac = $aleatorio", $horizonte) or die (mysql_error());
	$precio_consumibles = mysql_fetch_row($qry_sumar_consumibles);
	$suma_consumibles = $precio_consumibles[0];
}

  
 $sql = "UPDATE bases SET usuario_reg_b = $idUsuario, base_b = $nombre, id_area_b = $area, unidad_medida_r_b = $unidadMedidaResultado, precio_maquila_b = $suma_consumibles, id_equipo_b = $equipo where id_b = $id limit 1";

mysql_select_db($database_horizonte, $horizonte);
$insertar = mysql_query($sql, $horizonte);
 	
if (!$insertar) { echo $sql; }else { echo 1; }
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>