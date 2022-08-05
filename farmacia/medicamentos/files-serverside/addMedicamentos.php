<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $idU = sqlValue($_POST["id_user_reg_m"], "int");
 $id_mg = sqlValue($_POST["id_mg"], "int");
 $linea = sqlValue($_POST["linea_med"], "text");
 $dosis = sqlValue(mb_strtoupper($_POST["tex_dosis"]), "text");
 $nombre_c = sqlValue(mb_strtoupper($_POST["nombre_c_m"]), "text");
 $costo = sqlValue($_POST["costo_m"], "double");
 $precio_p = sqlValue($_POST["precio_p_m"], "double");
 $precio_h = sqlValue($_POST["precio_h_m"], "double");
 $precio_m = sqlValue($_POST["precio_m_m"], "double");
 $codigo_b = sqlValue($_POST["codigo_b_m"], "text");
 $max = sqlValue($_POST["max_p"], "int");
 $min = sqlValue($_POST["min_p"], "int");
 
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 $noTemp = sqlValue(date('Y-m-d-H-i-s'), "date");

 $sat = sqlValue($_POST["sat"], "text");
  
  //primero tenemos que saber si existe su tabulador, sino entnces escogemos el tabulador base
	$tabu = $_POST['miSucursalNS'].'_precio'; $resultT = mysql_query("SHOW COLUMNS FROM conceptos LIKE '$tabu' ");
	$existsT = (mysql_num_rows($resultT))?TRUE:FALSE;
	if($existsT) {
		$precio_nor = $_POST['miSucursalNS'].'_precio'; $precio_ur = $_POST['miSucursalNS'].'_precio_u';
		
		mysql_select_db($database_horizonte, $horizonte);
 		$sql = "INSERT INTO conceptos (usuario_to, concepto_to, $precio_nor, $precio_ur, id_area_to, id_medicamento_g, fecha_to, id_departamento_to, id_tipo_concepto_to, precio_to, precio_urgencia_to, precio1_to, precio_urgencia1_to, aleatorio_c, precio_h, precio_hu, costo_maquila_to, codigo_barras_to, descripcion_to, precio_m, precio_mu, costo_maquila_u_to,linea_c,sat_c) VALUES ($idU, $nombre_c, $precio_p, $precio_p, 61, $id_mg, $now, 3, 5, $precio_p, $precio_p, $precio_m, $precio_m, $noTemp, $precio_h, $precio_h, $costo, $codigo_b, $dosis, $precio_m, $precio_m, $costo,$linea,$sat)";
 
	}else{
		mysql_select_db($database_horizonte, $horizonte);
 		$sql = "INSERT INTO conceptos (usuario_to, concepto_to, precio_to, precio_urgencia_to, id_area_to, id_medicamento_g, fecha_to, id_departamento_to, id_tipo_concepto_to, precio1_to, precio_urgencia1_to, aleatorio_c, precio_h, precio_hu, costo_maquila_to, codigo_barras_to, descripcion_to, precio_m, precio_mu, costo_maquila_u_to,linea_c,sat_c) VALUES ($idU, $nombre_c, $precio_p, $precio_p, 61, $id_mg, $now, 3, 5, $precio_m, $precio_m, $noTemp, $precio_h, $precio_h, $costo, $codigo_b, $dosis, $precio_m, $precio_m, $costo,$linea,$sat)";
	}
	  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
 if (!$update) {
	echo $sql;
}else{
	mysql_select_db($database_horizonte, $horizonte);
	$id_con = "SELECT id_to from conceptos where concepto_to = $nombre_c limit 1";
	$id_concepto = mysql_query($id_con, $horizonte) or die (mysql_error());
	$id_c = mysql_fetch_row($id_concepto);
	if($id_c[0] != ''){
		$id_suc = $_POST['miSucursalNS'];
		mysql_select_db($database_horizonte, $horizonte);
		$insertar = "INSERT INTO max_min_stock (id_suc, id_producto, max_mm, min_mm, fecha_reg, id_u) VALUES ($id_suc, $id_c[0], $max, $min, $now, $idU)";
		$new_max_min = mysql_query($insertar, $horizonte) or die (mysql_error());
		if($new_max_min){
			echo 1;
		}else{ 
			echo $insertar;
		}
	}else{
		// echo "no etro al if";
		echo $id_c[0];
	}
}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>
