<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idH = sqlValue($_POST["id_hospitalizacion"], "int");
 $idP = sqlValue($_POST["idPaciente_nnm"], "int");
 $idU = sqlValue($_POST["idUsuario_nnm"], "int");
 $aleatorio = sqlValue($_POST["aleatorio_nnm"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 $tipoNota = 1;
 $notaMedica = sqlValue($_POST["notaMedicaC"], "text");
 $indicaciones = sqlValue($_POST["indiF"], "text");
 $recomendaciones = sqlValue($_POST["notaMedicamentosC"], "text");
 $idSV = sqlValue($_POST["idSV"], "int");
 $idNotaM = sqlValue($_POST["tipoNotaMed"], "int");
	
 mysql_select_db($database_horizonte, $horizonte); 
 $sql="INSERT INTO notas_de_hospital(id_hospitalizacion_nh,nota_nh,usuario_nh,fecha_nh,aleatorio_nh,indicaciones_nh,recomendaciones_nh,tipo_nota_nh,id_sv_nh,id_nota_nh) VALUES($idH,$notaMedica,$idU,$now,$aleatorio,$indicaciones,$recomendaciones,$tipoNota,$idSV,$idNotaM)";
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
 if (!$update) { echo $sql; }else{  echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>