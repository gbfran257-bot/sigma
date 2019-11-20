<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $noTemp = sqlValue($_POST["noAleatorio"], "text");
 $referencia = sqlValue($_POST["referencia"], "int");
 $idU = sqlValue($_POST["idU"], "int");

	 mysql_select_db($database_horizonte, $horizonte); 
	 $resultC = mysql_query("SELECT id_vr, valor_referencia_vr from valores_referencia where id_vr = $referencia ", $horizonte) or die (mysql_error());
	 $rowC = mysql_fetch_row($resultC);
	 
 $idR = sqlValue($rowC[0], "int");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 
 //buscamos el id de la base con el noAleatorio, si existe la base, entonces la insertamos, sino no
 mysql_select_db($database_horizonte, $horizonte); 
 $resultC5 = mysql_query("SELECT count(id_b) from bases where aleatorio_b = $noTemp ", $horizonte) or die (mysql_error());
 $rowC5 = mysql_fetch_row($resultC5);
 
 mysql_select_db($database_horizonte, $horizonte);
 $resultC1 = mysql_query("SELECT count(id_avr) from asignar_valor_referencia where id_valor_referencia_avr = $referencia and aleatorio_avr = $noTemp", $horizonte) or die (mysql_error());
 $rowC1 = mysql_fetch_row($resultC1);
 
 if($rowC5[0]>0){
	mysql_select_db($database_horizonte, $horizonte); 
 	$resultC6 = mysql_query("SELECT id_b from bases where aleatorio_b = $noTemp ", $horizonte) or die (mysql_error());
 	$rowC6 = mysql_fetch_row($resultC6);
	
	//if($rowC1[0]<1){
		mysql_select_db($database_horizonte, $horizonte); 
		$sql="INSERT INTO asignar_valor_referencia(aleatorio_avr,id_valor_referencia_avr,usuario_reg_avr,fecha_reg_avr, id_base_avr)";
		$sql.= "VALUES ($noTemp, $referencia, $idU, $now, $rowC6[0])";
		$update = mysql_query($sql, $horizonte) or die (mysql_error());
		if (!$update) { echo $sql; }else{ echo 1; }
	//}else{echo 1;}
 }else{
	if($rowC1[0]<1){
		mysql_select_db($database_horizonte, $horizonte); 
		$sql="INSERT INTO asignar_valor_referencia(aleatorio_avr,id_valor_referencia_avr,usuario_reg_avr,fecha_reg_avr)";
		$sql.= "VALUES ($noTemp, $referencia, $idU, $now)";
		$update = mysql_query($sql, $horizonte) or die (mysql_error());
		if (!$update) { echo $sql; }else{ echo 1; }
	}else{echo 1;}
 }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>