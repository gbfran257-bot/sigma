<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idP = sqlValue($_POST["idP"], "int");
 $idU = sqlValue($_POST["idU"], "int");

 	mysql_select_db($database_horizonte, $horizonte);
 	$result = mysql_query("SELECT COUNT(id_hc) from historia_clinica where id_paciente_hc = $idP", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result);
	
	if($row[0]==0){
		mysql_select_db($database_horizonte, $horizonte);
 		$sql1 = "INSERT INTO historia_clinica (id_paciente_hc, id_usuario_hc, fecha_temporal_hc)";
 		$sql1.= "VALUES ($idP, $idU, now())";
  
		$update1 = mysql_query($sql1, $horizonte);
	
		if (!$update1) {
 			echo $update1;
 		}else{echo "ok";}
	}else{echo "ok";}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>