<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	/*$id_mh = sqlValue($_POST["id_mh"], "int");
	$id_u = sqlValue($_POST["id_u"], "int");
	$now = sqlValue(date('Y-m-d H:i:s'), "date");
	$banderaExistencias = false;
	$idExistencias = 0;
	$cantExistencias = 0;

	mysql_select_db($database_horizonte, $horizonte);
	$id_c = "SELECT id_medicamento_mh from medicamentos_hospital where id_mh = $id_mh";
	$id_concepto = mysql_query($id_c, $horizonte) or die (mysql_error());
	$id_con = mysql_fetch_row($id_concepto);
	$medicamento = $id_con[0];

	mysql_select_db($database_horizonte, $horizonte);
	$existencias_shb = "SELECT shb.existencias, shb.id FROM stock_has_bach shb LEFT JOIN medicamentos_hospital mh ON mh.ref_stock_pivote = shb.id WHERE mh.id_mh  = $id_mh LIMIT 1";
	$cantidad_shb = mysql_query($existencias_shb, $horizonte) or die (mysql_error());
	$cant_shb = mysql_fetch_row($cantidad_shb);
	$cantidad = $cant_shb[0];
	$id_shb = $cant_shb[1];

	if($cantidad > 0){
		mysql_select_db($database_horizonte, $horizonte);
		$sql = "INSERT INTO medicamentos_aplicados_hospi(id_medicamento_hospital_mah, id_usuario_mah, fecha_mah, id_stock) values($id_mh, $id_u, $now, $id_shb)";
		$update = mysql_query($sql, $horizonte) or die (mysql_error());

		$cantidad-=1;
		mysql_select_db($database_horizonte, $horizonte);
		$sql_restar = "UPDATE stock_has_bach SET existencias = $cantidad WHERE id = $id_shb LIMIT 1";
		$update_restar = mysql_query($sql_restar, $horizonte) or die (mysql_error());

		if(!$update){
			echo $sql;
		} 
		else{ 
			echo 1;
		}
	}else{
		echo 2;
	}*/

	$id_mh = sqlValue($_POST["id_mh"], "int");
	$id_u = sqlValue($_POST["id_u"], "int");
	$id_shb = sqlValue($_POST["id_shb"], "int");
	$now = sqlValue(date('Y-m-d H:i:s'), "date");

	mysql_select_db($database_horizonte, $horizonte);
	$sql = "INSERT INTO medicamentos_aplicados_hospi(id_medicamento_hospital_mah, id_usuario_mah, fecha_mah, id_stock) values($id_mh, $id_u, $now, $id_shb)";
	$update = mysql_query($sql, $horizonte) or die (mysql_error());

	if(!$update){
		echo $sql;
	} 
	else{ 
		echo 1;
	}

 	//Cerrar conexión a la Base de Datos
 	mysql_close($horizonte);
?>
