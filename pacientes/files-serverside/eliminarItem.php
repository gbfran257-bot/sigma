<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$idConcepto = sqlValue($_POST["idConcepto"], "int");
$id_u = sqlValue($_POST["id_u"], "int");
$now = sqlValue(date('Y-m-d H:i:s'), "date");

if($idConcepto == 0){
	echo 1;
}else{
	//buscamos si el concepto a eliminar es uno ya guardado en la ov
	mysql_select_db($database_horizonte, $horizonte);
	$qry_count = mysql_query("SELECT COUNT(id_vc) FROM venta_conceptos WHERE temporal_vc = 0 AND referencia_vc IS NOT NULL AND id_vc = $idConcepto", $horizonte) or die (mysql_error());
	$qry_get_count = mysql_fetch_row($qry_count);

	if($qry_get_count[0] > 0){
		//buscamos la informacion que se insertara en la tabla historial_mod_pagos
		mysql_select_db($database_horizonte, $horizonte);
		$qry_search = mysql_query("SELECT referencia_vc, id_concepto_es, precio_vc FROM venta_conceptos WHERE temporal_vc = 0 AND referencia_vc IS NOT NULL AND id_vc = $idConcepto", $horizonte) or die (mysql_error());
		$get_qry_search = mysql_fetch_row($qry_search);

		$referencia_vc = sqlValue($get_qry_search[0], "text");
		$id_concepto_es = sqlValue($get_qry_search[1], "int");
		$precio_vc = sqlValue($get_qry_search[2], "double");
		//insertamos los datos
		mysql_select_db($database_horizonte, $horizonte);
		$query_add_hmp = "INSERT INTO historial_mod_pagos (referencia_hmp, tipo_mov_hmp, concepto_hmp, total_concepto_hmp, usuario_hmp, fecha_hmp) VALUES ($referencia_vc, 0, $id_concepto_es, $precio_vc, $id_u, $now)"; 
		$execute_query_hmp = mysql_query($query_add_hmp, $horizonte) or die (mysql_error());
	}

	//este codigo era el original antes de implementar la orden de venta abierta.
	mysql_select_db($database_horizonte, $horizonte); 
	$sql = "delete from venta_conceptos where id_vc = $idConcepto limit 1";
	$sql_1 = "delete from venta_conceptos_1 where id_vc = $idConcepto limit 1";
	$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
	if (!$update) {
		echo $sql;
	}else{ 
		echo 1; 
		$update_1 = mysql_query($sql_1, $horizonte) or die (mysql_error());
	}
}
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>