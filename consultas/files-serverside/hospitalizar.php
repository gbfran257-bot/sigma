<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idP = sqlValue($_POST["idP"], "int");
 $idU = sqlValue($_POST["idU"], "int");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 $idMedicoTratante = sqlValue($_POST["idU"], "int");
 $idCama = sqlValue($_POST["id_cama_h"], "int");
 $motivo = sqlValue($_POST["motivo_h"], "text");
 $id_consulta = sqlValue($_POST["id_vc"], "int");
  
 mysql_select_db($database_horizonte, $horizonte); 
 $result1= mysql_query("SELECT count(id_h) from hospitalizacion where id_consulta_vc_h = $id_consulta", $horizonte) or die (mysql_error());
 $row1 = mysql_fetch_row($result1);
 
 if($row1[0] < 1){
	mysql_select_db($database_horizonte, $horizonte);
	$sql = "INSERT into hospitalizacion(id_paciente_h, id_medicoh_h, fecha_inicio_h, id_consulta_vc_h, id_usuario_h, id_cama_h, motivo_h) values ($idP, $idMedicoTratante, $now, $id_consulta, $idU, $idCama, $motivo)";
	  
	$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
	if(!$update){ 
		echo $sql; 
	}else{ 
		// Actualiza la cama a ocupado
		$sql = "UPDATE camas SET ocupado_ca = 1 WHERE id_ca = $idCama";
		$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
		if (!$update) {
			echo $sql; 	
		} else {
			echo 1;
		} 
	}
 }else{echo 1;}
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>
