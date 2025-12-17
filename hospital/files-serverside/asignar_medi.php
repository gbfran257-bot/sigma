<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	$id_h = sqlValue($_POST["id_h"], "int");
	$id_m = sqlValue($_POST["id_m"], "int");
	$indicacion = sqlValue($_POST["indicacion"], "text");
	$id_u = sqlValue($_POST["id_u"], "int");
	$now = sqlValue(date('Y-m-d H:i:s'), "date");
	$stock_pivote = sqlValue($_POST["stock_pivote"], "int");
	$estatus = 18; //id 18 del catalogo de estatus es Aplicar 

	//Revisamos si el medicamento no está asignado en la hospiralización
	mysql_select_db($database_horizonte, $horizonte);
 	$result = mysql_query("SELECT count(id_mh) from medicamentos_hospital where id_medicamento_mh = $id_m and id_hospitalizacion_mh = $id_h", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result);

	if($row[0]<1){
		
		mysql_select_db($database_horizonte, $horizonte);
		$sql = "INSERT INTO medicamentos_hospital(id_hospitalizacion_mh, id_medicamento_mh, id_u_mh, fecha_mh, indicacion_mh, estatus_mh, ref_stock_pivote, aleatorio_mh) values($id_h, $id_m, $id_u, $now, $indicacion,$estatus,$stock_pivote, '')";
		$update = mysql_query($sql, $horizonte) or die (mysql_error());

		if(!$update){echo $sql;} else{ echo 1; }
	}else{
		mysql_select_db($database_horizonte, $horizonte);
		$sql_s_p = "UPDATE medicamentos_hospital SET indicacion_mh = $indicacion, ref_stock_pivote = $stock_pivote WHERE id_medicamento_mh = $id_m AND id_hospitalizacion_mh = $id_h";
		$update_s_p = mysql_query($sql_s_p, $horizonte) or die (mysql_error());
		echo 1;
	}

 	//Cerrar conexión a la Base de Datos
 	mysql_close($horizonte);
?>
