<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");
//Generales
 $la_refe = sqlValue($_POST["ref"], "text");
 $aleatorio = sqlValue(date('Y-m-d-H-i-s'), "text");
 $idU = sqlValue($_POST["user"], "int");
 $pago_c = sqlValue($_POST["pago_ov_c"], "double");
 $pago_i = sqlValue($_POST["pago_ov_i"], "double");
 $pago_l = sqlValue($_POST["pago_ov_l"], "double");
 $pago_f = sqlValue($_POST["pago_ov_f"], "double");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 $forma_pago_ov = sqlValue($_POST["formaPagoP"], "int");
 $opcion_pa = sqlValue($_POST["opcion_pa"], "int");

 //Si $opcion = 2, se deben borrar los pagos anteriores y poner un nuevo pago
 if($opcion_pa==2){
	 $sqlCB = "DELETE from pagos_ov where referencia_pag = $la_refe and departamento_pa is NULL ";
	 mysql_select_db($database_horizonte, $horizonte); $insertarCB = mysql_query($sqlCB, $horizonte) or die (mysql_error());
 }

 $conti = 0;

 if($_POST["pago_ov_c"]>0 and $_POST["pago_ov_c"]!=''){
	$sqlF = "INSERT INTO pagos_ov(pago_pag, usuario_pag, fecha_pag, referencia_pag, no_temp_pag, forma_pago_pag, departamento_pa) VALUES ($pago_c, $idU, $now, $la_refe, $aleatorio, $forma_pago_ov,'4') ";
	mysql_select_db($database_horizonte, $horizonte); $insertarF = mysql_query($sqlF, $horizonte) or die (mysql_error()); $conti++;
 }
 if($_POST["pago_ov_i"]>0 and $_POST["pago_ov_i"]!=''){
	$sqlF1 = "INSERT INTO pagos_ov(pago_pag, usuario_pag, fecha_pag, referencia_pag, no_temp_pag, forma_pago_pag, departamento_pa) VALUES ($pago_i, $idU, $now, $la_refe, $aleatorio, $forma_pago_ov,'2') ";
	mysql_select_db($database_horizonte, $horizonte); $insertarF1 = mysql_query($sqlF1, $horizonte) or die (mysql_error()); $conti++;
 }
 if($_POST["pago_ov_l"]>0 and $_POST["pago_ov_l"]!=''){
	$sqlF2 = "INSERT INTO pagos_ov(pago_pag, usuario_pag, fecha_pag, referencia_pag, no_temp_pag, forma_pago_pag, departamento_pa) VALUES ($pago_l, $idU, $now, $la_refe, $aleatorio, $forma_pago_ov,'1') ";
	mysql_select_db($database_horizonte, $horizonte); $insertarF2 = mysql_query($sqlF2, $horizonte) or die (mysql_error()); $conti++;
 }
 if($_POST["pago_ov_f"]>0 and $_POST["pago_ov_f"]!=''){
	$sqlF3 = "INSERT INTO pagos_ov(pago_pag, usuario_pag, fecha_pag, referencia_pag, no_temp_pag, forma_pago_pag, departamento_pa) VALUES ($pago_f, $idU, $now, $la_refe, $aleatorio, $forma_pago_ov,'3') ";
	mysql_select_db($database_horizonte, $horizonte); $insertarF3 = mysql_query($sqlF3, $horizonte) or die (mysql_error()); $conti++;
 }

 if($conti == 0){
	$sqlF4 = "INSERT INTO pagos_ov(pago_pag, usuario_pag, fecha_pag, referencia_pag, no_temp_pag, forma_pago_pag, departamento_pa) VALUES ('0', $idU, $now, $la_refe, $aleatorio, $forma_pago_ov,'1') ";
	mysql_select_db($database_horizonte, $horizonte); $insertarF4 = mysql_query($sqlF4, $horizonte) or die (mysql_error());
 }

 echo 1;
	
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>