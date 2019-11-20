<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idUsuario = sqlValue($_POST["idUsuarioB"], "int");
 $aleatorio = sqlValue($_POST["aleatorioB"], "text");
 $nombre = sqlValue($_POST["nombreB"], "text");
 $descripcion = sqlValue($_POST["descripcionB"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO convenios (convenio_cv, descripcion_cv, usuario_cv, fecha_cv, aleatorio_cv)";
 $sql.= "VALUES ($nombre, $descripcion, $idUsuario, $now, $aleatorio)";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) { 
	echo $sql; 
} else{
	mysql_select_db($database_horizonte, $horizonte);
 	$result = mysql_query("SELECT id_cv from convenios where aleatorio_cv = $aleatorio limit 1 ", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result); $idConvenio = sqlValue($row[0], "int");
	
	$sql1 = "UPDATE asigna_conceptos_convenios SET id_convenio_ac = $idConvenio where aleatorio_ac = $aleatorio ";

	mysql_select_db($database_horizonte, $horizonte);
	$insertar = mysql_query($sql1, $horizonte);
		
	if (!$insertar) { echo $sql1;
	 }else { echo 1; }
}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>