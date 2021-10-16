<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	$id_mh = sqlValue($_POST["id_mh"], "int");
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
	$ext = "SELECT s.id, s.existencias from stock_has_bach s left join conceptos c  on c.id_to = s.id_Producto where s.id_Producto = $medicamento order by s.id DESC";
	$existen = mysql_query($ext, $horizonte) or die (mysql_error());
	while ($stock = mysql_fetch_assoc($existen)){
		 if($stock['existencias'] >= 1){
			$idExistencias =  $stock['id'];
			$cantExistencias = $stock['existencias'];
			$banderaExistencias = true;
		 }else{
			if($idExistencias != 0){
				$banderaExistencias = true;
			}
		 }
	}

	if($banderaExistencias){
		mysql_select_db($database_horizonte, $horizonte);
		$sql = "INSERT INTO medicamentos_aplicados_hospi(id_medicamento_hospital_mah, id_usuario_mah, fecha_mah) values($id_mh, $id_u, $now)";
		$update = mysql_query($sql, $horizonte) or die (mysql_error());

		if(!$update){
			echo $sql;
		} 
		else{ 
			mysql_select_db($database_horizonte, $horizonte);
			$menos = "UPDATE stock_has_bach SET existencias = (existencias -1) where id = $idExistencias";
			$resta_existencias = mysql_query($menos, $horizonte) or die (mysql_error());

			if(!$resta_existencias){echo $menos;}else{ echo 1; }
		}
		
	}else{
		echo 2;
	}

 	//Cerrar conexión a la Base de Datos
 	mysql_close($horizonte);
?>
