<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idP = sqlValue($_POST["id_paciente_tera"], "int");
 $idU = sqlValue($_POST["id_usuario_tera"], "int");
 $motivo = sqlValue($_POST["motivo_tera"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 
 mysql_select_db($database_horizonte, $horizonte); 
 $resultC = mysql_query("SELECT count(id_t) from rehabilitacion where id_paciente_t = $idP and estatus_t < 3", $horizonte) or die (mysql_error());
 $rowC = mysql_fetch_row($resultC);
 
 if($rowC[0]==0){
	 mysql_select_db($database_horizonte, $horizonte);
	 $sql = "INSERT INTO rehabilitacion (id_paciente_t, motivo_t, usuario_ingreso_t, fecha_ingreso_t)";
	 $sql.= "VALUES ($idP, $motivo, $idU, $now )";
	  
	 $update = mysql_query($sql, $horizonte) or die (mysql_error());
		
	 if (!$update){ echo $sql; }else{ echo 1; }
 }else{echo 'El paciente cuenta con una terapia en curso, favor de verificar.';}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>