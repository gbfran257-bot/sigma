<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $id_estudio = sqlValue($_POST["id_estudio"], "int");
 $id_usuario = sqlValue($_POST["id_usuario"], "int");
 //si chechaPro es 1 el estudio se procesa solo, si es 2 se procesa en masa
 $checaPro = sqlValue($_POST["checaPro"], "int");
 $referencia = sqlValue($_POST["referencia"], "text");

 mysql_select_db($database_horizonte, $horizonte);
 if($checaPro == 1){

	$sql = "UPDATE historial_estudios SET quien_proceso = $id_usuario WHERE id_estudio = $id_estudio LIMIT 1 ";
	$update = mysql_query($sql, $horizonte);
	
	if(!$update){
		echo $sql; 
	}else{
		echo 1; 
	}

 }else if($checaPro == 2){

	$consulta = "SELECT id_vc FROM venta_conceptos WHERE referencia_vc = $referencia";
	$ejecutar_query = mysql_query($consulta, $horizonte);

	// Recuperar datos de la consulta SQL e iterar sobre ellos
	while ($resultado = mysql_fetch_assoc($ejecutar_query)) {
		$sql1 = "UPDATE historial_estudios SET quien_proceso = $id_usuario WHERE id_estudio = ".$resultado['id_vc']." LIMIT 1 ";
		$update1 = mysql_query($sql1, $horizonte);
	}

 }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
 

?>