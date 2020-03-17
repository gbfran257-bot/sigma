<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $idU = sqlValue($_POST["id_user_reg_m"], "int");
 $id_mg = sqlValue($_POST["id_mg"], "int");
 $dosis = sqlValue(mb_strtoupper($_POST["tex_dosis"]), "text");
 $nombre_c = sqlValue(mb_strtoupper($_POST["nombre_c_m"]), "text");
 $costo = sqlValue($_POST["costo_m"], "double");
 $precio_p = sqlValue($_POST["precio_p_m"], "double");
 $precio_h = sqlValue($_POST["precio_h_m"], "double");
 $precio_m = sqlValue($_POST["precio_m_m"], "double");
 $codigo_b = sqlValue($_POST["codigo_b_m"], "text");
 $id_medi = sqlValue($_POST["id_med_up"], "int");
 
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
  
  //primero tenemos que saber si existe su tabulador, sino entnces escogemos el tabulador base
	$tabu = $_POST['miSucursalNS'].'_precio'; $resultT = mysql_query("SHOW COLUMNS FROM conceptos LIKE '$tabu' ");
	$existsT = (mysql_num_rows($resultT))?TRUE:FALSE;
	if($existsT) {
		$precio_nor = $_POST['miSucursalNS'].'_precio'; $precio_ur = $_POST['miSucursalNS'].'_precio_u';
		
		mysql_select_db($database_horizonte, $horizonte);
 		$sql = "UPDATE conceptos set concepto_to = $nombre_c, $precio_nor = $precio_p, $precio_ur = $precio_p, id_medicamento_g = $id_mg, precio_to = $precio_p, precio_urgencia_to = $precio_p, precio1_to = $precio_m, precio_urgencia1_to = $precio_m, precio_h = $precio_h, precio_hu = $precio_h, costo_maquila_to = $costo, codigo_barras_to = $codigo_b, descripcion_to = $dosis, precio_m = $precio_m, precio_mu = $precio_m, costo_maquila_u_to = $costo where id_to = $id_medi limit 1";
 
	}else{
		mysql_select_db($database_horizonte, $horizonte);
 		$sql = "UPDATE conceptos set concepto_to = $nombre_c, precio_to = $precio_p, precio_urgencia_to = $precio_p, id_medicamento_g = $id_mg, precio1_to = $precio_m, precio_urgencia1_to = $precio_m, precio_h = $precio_h, precio_hu = $precio_h, costo_maquila_to = $costo, codigo_barras_to = $codigo_b, descripcion_to = $dosis, precio_m = $precio_m, precio_mu = $precio_m, costo_maquila_u_to = $costo where id_to = $id_medi limit 1";
	}
	  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
 if (!$update) {echo $sql;} else{ echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>
