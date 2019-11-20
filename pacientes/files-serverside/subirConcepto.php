<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $tipo_c = sqlValue($_POST["tipo_c"], "int");
 $id_c = sqlValue($_POST["id_c"], "int");
 $id_beneficio = sqlValue($_POST["id_beneficio"], "int");
 $id_p = sqlValue($_POST["id_p"], "int");
 $noTemp = sqlValue($_POST["aleatorio"], "text");
 $idU = sqlValue($_POST["id_u"], "int");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 $id_medico = sqlValue($_POST["id_medico"], "int");
 $precio = sqlValue($_POST["precio"], "double");
 
 if($_POST["id_beneficio"]>0){
	 mysql_select_db($database_horizonte, $horizonte); 
	 $resultC1 = mysql_query("SELECT id_cb from conceptos_beneficios where id_convenio_paciente_cb = $id_beneficio and id_concepto_convenio_cb = $id_c ", $horizonte) or die (mysql_error());
	 $rowC1 = mysql_fetch_row($resultC1); $id_concepto_beneficio = $rowC1[0];
 }else{$id_concepto_beneficio = 0;}
   
//Checamos si existe otro concepto con este número aleatorio:
 mysql_select_db($database_horizonte, $horizonte); 
 $resultC = mysql_query("SELECT count(id_vc) from venta_conceptos where no_temp_vc = $noTemp and id_concepto_es = $id_c", $horizonte) or die (mysql_error());
 $rowC = mysql_fetch_row($resultC);
 	
 $sql = "DELETE from venta_conceptos where id_concepto_es = $id_c and no_temp_vc = $noTemp";
 $sql_1 = "DELETE from venta_conceptos_1 where id_concepto_es = $id_c and no_temp_vc = $noTemp";//Para actualizar
 $update_1 = mysql_query($sql_1, $horizonte) or die (mysql_error());
  
  $update = mysql_query($sql, $horizonte) or die (mysql_error());
  if (!$update) { echo $sql; }else{
  	$sql1="INSERT INTO venta_conceptos(no_temp_vc, id_paciente_vc, id_usuario_vc, id_convenio_vc, id_concepto_es, fecha_venta_vc, usuarioEdo1_e, fechaEdo1_e, id_conceptos_beneficios, id_personal_medico_vc, precio_vc) VALUES ($noTemp, $id_p, $idU, $id_beneficio, $id_c, $now, $idU, $now, $id_concepto_beneficio, $id_medico, $precio)";
	$update1 = mysql_query($sql1, $horizonte) or die (mysql_error());
	if (!$update1) { echo $sql1; }else{
		echo 1;
		
		$sql1_1="INSERT INTO venta_conceptos_1(no_temp_vc, id_paciente_vc, id_usuario_vc, id_convenio_vc, id_concepto_es, fecha_venta_vc, usuarioEdo1_e, fechaEdo1_e, id_conceptos_beneficios, id_personal_medico_vc, precio_vc) VALUES ($noTemp, $id_p, $idU, $id_beneficio, $id_c, $now, $idU, $now, $id_concepto_beneficio, $id_medico, $precio)";
		$update1_1 = mysql_query($sql1_1, $horizonte) or die (mysql_error());
	}
  }
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>