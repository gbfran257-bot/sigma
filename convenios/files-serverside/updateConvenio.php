<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $id = sqlValue($_POST["idBeneficio"], "int");
 $idUsuario = sqlValue($_POST["idUsuarioB"], "int");
 $aleatorio = sqlValue($_POST["aleatorioB"], "text");
 $nombre = sqlValue($_POST["nombreB"], "text");
 $descripcion = sqlValue($_POST["descripcionB"], "text");
  
 $sql = "UPDATE convenios SET convenio_cv = $nombre, descripcion_cv = $descripcion where id_cv = $id limit 1";

mysql_select_db($database_horizonte, $horizonte);
$insertar = mysql_query($sql, $horizonte);
 	
if (!$insertar) {
	echo $sql;
 }else {
	 $sql1 = "UPDATE asigna_conceptos_convenios SET id_convenio_ac = $id where aleatorio_ac = $aleatorio ";

	mysql_select_db($database_horizonte, $horizonte);
	$insertar1 = mysql_query($sql1, $horizonte);
		
	if (!$insertar1) { echo $sql1;
	 }else { echo 1; }
  }
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>