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
 $id_medi = sqlValue($_POST["id_med_up"], "int");
 $max = sqlValue($_POST["max_p"], "int");
 $min = sqlValue($_POST["min_p"], "int");
 
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 $sat = sqlValue($_POST["sat"], "text");
  
  //primero tenemos que saber si existe su tabulador, sino entnces escogemos el tabulador base
	$tabu = $_POST['miSucursalNS'].'_precio'; $resultT = mysql_query("SHOW COLUMNS FROM conceptos LIKE '$tabu' ");
	$existsT = (mysql_num_rows($resultT))?TRUE:FALSE;
	if($existsT) {
		$precio_nor = $_POST['miSucursalNS'].'_precio'; $precio_ur = $_POST['miSucursalNS'].'_precio_u';
		
		mysql_select_db($database_horizonte, $horizonte);
 		$sql = "UPDATE conceptos set concepto_to = $nombre_c, $precio_nor = $precio_p, $precio_ur = $precio_p, id_medicamento_g = $id_mg, precio_to = $precio_p, precio_urgencia_to = $precio_p, precio1_to = $precio_m, precio_urgencia1_to = $precio_m, precio_h = $precio_h, precio_hu = $precio_h, costo_maquila_to = $costo, codigo_barras_to = $codigo_b, descripcion_to = $dosis, precio_m = $precio_m, precio_mu = $precio_m, costo_maquila_u_to = $costo, linea_c = $linea, sat_c = $sat where id_to = $id_medi limit 1";
 
	}else{
		mysql_select_db($database_horizonte, $horizonte);
 		$sql = "UPDATE conceptos set concepto_to = $nombre_c, precio_to = $precio_p, precio_urgencia_to = $precio_p, id_medicamento_g = $id_mg, precio1_to = $precio_m, precio_urgencia1_to = $precio_m, precio_h = $precio_h, precio_hu = $precio_h, costo_maquila_to = $costo, codigo_barras_to = $codigo_b, descripcion_to = $dosis, precio_m = $precio_m, precio_mu = $precio_m, costo_maquila_u_to = $costo, linea_c = $linea, sat_c = $sat where id_to = $id_medi limit 1";
	}
	  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) {
	echo $sql;
}else{
	mysql_select_db($database_horizonte, $horizonte);
	$id_su = $_POST['miSucursalNS'];
	$result3 = mysql_query("SELECT id from max_min_stock m where m.id_producto = $id_medi and m.id_suc = $id_su", $horizonte) or die(mysql_error());
	$row3 = mysql_fetch_row($result3); 
	if($row3[0] != ''){
		$sql1 ="UPDATE max_min_stock SET max_mm = $max, min_mm = $min, fecha_reg = $now, id_u = $idU where id = $row3[0] limit 1";
		
	}else{
		$sql1 = "INSERT INTO max_min_stock (id_suc, id_producto, max_mm, min_mm, fecha_reg, id_u) VALUES ($id_su, $id_medi, $max, $min, $now, $idU)";
	}
	$new_max_min = mysql_query($sql1, $horizonte) or die (mysql_error());
	if(!$new_max_min){
		echo $sql1 ;
	}else{
		echo 1;
	}
}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>
