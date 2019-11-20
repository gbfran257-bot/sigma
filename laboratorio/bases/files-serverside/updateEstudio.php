<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $id = sqlValue($_POST["idPacienteN"], "int");
 $idUsuario = sqlValue($_POST["idUsuarioP"], "int");
 $nombre = sqlValue($_POST["nombreP"], "text");
 $area = sqlValue($_POST["areaB"], "int");
 $unidadMedidaResultado = sqlValue($_POST["id_umBase"], "int");
 $precioEstimado = sqlValue($_POST["precioP"], "double");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 $aleatorio = sqlValue($_POST["aleatorioB"], "text");
 if(isset($_POST["equipoMu1"])){
	 $equipo = sqlValue($_POST["equipoMu1"], "int");
 }else{$equipo = 'NULL';}
  
 $sql = "UPDATE bases SET usuario_reg_b = $idUsuario, base_b = $nombre, id_area_b = $area, unidad_medida_r_b = $unidadMedidaResultado, precio_maquila_b = $precioEstimado, id_equipo_b = $equipo where id_b = $id limit 1";

mysql_select_db($database_horizonte, $horizonte);
$insertar = mysql_query($sql, $horizonte);
 	
if (!$insertar) { echo $sql; }else { echo 1; }
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>