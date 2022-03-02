<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idUsuario = sqlValue($_POST["idusuarioNM"], "int");
 $nombre = sqlValue(mb_strtoupper($_POST["nombreNM"]), "text");
 $nota = sqlValue($_POST["input"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 $a = sqlValue($_POST["a"], "text");
 $temporal = sqlValue($_POST["temporal"], "text");
 
 mysql_select_db($database_horizonte, $horizonte);
 if(!isset($_POST["a"]) or $_POST["a"]==''){//Estan creando al nuevo usuario
 	$sql = "INSERT INTO notas_medicas(nombre_nm, nota_nm, temporal_nm, fecha_nm, tipo_nm, user_reg_nm) VALUES($nombre, $nota, $temporal, $now, 4, $idUsuario)";	 
 }else{//Usuario que ya existe
	 $sql= "INSERT INTO notas_medicas(nombre_nm, nota_nm, usuario_nm, temporal_nm, fecha_nm, tipo_nm, user_reg_nm) VALUES($nombre, $nota, $a,$temporal, $now, 4, $idUsuario)";
 }  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) { echo $sql; }else{ echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>
