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
 
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 $noTemp = sqlValue(date('Y-m-d-H-i-s'), "date");
  
  //primero tenemos que saber si existe su tabulador, sino entnces escogemos el tabulador base
	$tabu = $_POST['miSucursalNS'].'_precio'; $resultT = mysql_query("SHOW COLUMNS FROM conceptos LIKE '$tabu' ");
	$existsT = (mysql_num_rows($resultT))?TRUE:FALSE;
	if($existsT) {
		$precio_nor = $_POST['miSucursalNS'].'_precio'; $precio_ur = $_POST['miSucursalNS'].'_precio_u';
		
		mysql_select_db($database_horizonte, $horizonte);
 		$sql = "INSERT INTO conceptos (usuario_to, concepto_to, $precio_nor, $precio_ur, id_area_to, id_medicamento_g, fecha_to, id_departamento_to, id_tipo_concepto_to, precio_to, precio_urgencia_to, precio1_to, precio_urgencia1_to, aleatorio_c, precio_h, precio_hu, costo_maquila_to, codigo_barras_to, descripcion_to, precio_m, precio_mu, costo_maquila_u_to,linea_c) VALUES ($idU, $nombre_c, $precio_p, $precio_p, 61, $id_mg, $now, 3, 5, $precio_p, $precio_p, $precio_m, $precio_m, $noTemp, $precio_h, $precio_h, $costo, $codigo_b, $dosis, $precio_m, $precio_m, $costo,$linea)";
 
	}else{
		mysql_select_db($database_horizonte, $horizonte);
 		$sql = "INSERT INTO conceptos (usuario_to, concepto_to, precio_to, precio_urgencia_to, id_area_to, id_medicamento_g, fecha_to, id_departamento_to, id_tipo_concepto_to, precio1_to, precio_urgencia1_to, aleatorio_c, precio_h, precio_hu, costo_maquila_to, codigo_barras_to, descripcion_to, precio_m, precio_mu, costo_maquila_u_to,linea_c) VALUES ($idU, $nombre_c, $precio_p, $precio_p, 61, $id_mg, $now, 3, 5, $precio_m, $precio_m, $noTemp, $precio_h, $precio_h, $costo, $codigo_b, $dosis, $precio_m, $precio_m, $costo,$linea)";
	}
	  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
 if (!$update) {echo $sql;} else{ echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>
