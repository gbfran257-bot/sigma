<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idP = sqlValue($_POST["idP"], "int");
 $idC = sqlValue($_POST["idC"], "int");
 $idU = sqlValue($_POST["idU"], "int");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 
 mysql_select_db($database_horizonte, $horizonte); 
 $result = mysql_query("SELECT referencia_vc from venta_conceptos where id_vc = $idC", $horizonte) or die (mysql_error());
 $row = mysql_fetch_row($result); $referencia = sqlValue($row[0], "text");
 
 mysql_select_db($database_horizonte, $horizonte); 
 $result1= mysql_query("SELECT count(id_h) from hospitalizacion where id_consulta_vc_h = $idC", $horizonte) or die (mysql_error());
 $row1 = mysql_fetch_row($result1);
 
 if($row1[0] < 1){
	mysql_select_db($database_horizonte, $horizonte);
	 $sql = "INSERT into hospitalizacion (id_paciente_h, id_medicoh_h, fecha_inicio_h, id_consulta_vc_h, referencia_vc_h) values ($idP, $idU, $now, $idC, $referencia)";
	  
	$update = mysql_query($sql, $horizonte) or die (mysql_error());
		
	if (!$update) {
		echo $sql;
	 }else {
		 echo 1;
	}
 }else{echo 1;}
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>