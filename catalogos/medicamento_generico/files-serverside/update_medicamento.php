<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

//  $clv = sqlValue($_POST["clv_carrera"], "int");
 $idP = sqlValue($_POST["idm"], "int");
//  $nombre = sqlValue(mb_strtoupper($_POST["nombre_carrera"]), "text");
//  $abreviacion = sqlValue($_POST["abreviacion_u"], "text");

if(empty($_POST['clv_m'])){$clave_m = "NULL";}else{$clave_m = mb_strtoupper(sqlValue($_POST["clv_m"], "text"));}
if(empty($_POST['nombre_generico_m'])){$nombre = "NULL";}else{$nombre = mb_strtoupper(sqlValue($_POST["nombre_generico_m"], "text"));}
if(empty($_POST['desc_m'])){$descripcion = "NULL";}else{$descripcion = mb_strtoupper(sqlValue($_POST["desc_m"], "text"));}
if(empty($_POST['cant_m'])){$cantidad = "NULL";}else{$cantidad = mb_strtoupper(sqlValue($_POST["cant_m"], "text"));}
if(empty($_POST['nivel_m'])){$nivel = "NULL";}else{$nivel = mb_strtoupper(sqlValue($_POST["nivel_m"], "text"));}
if(empty($_POST['present_m'])){$presentacion =  "NULL";}else{$presentacion = mb_strtoupper(sqlValue($_POST["present_m"], "text"));}
if(empty($_POST['Rembarazo_m'])){$rEmbarazo =  "NULL";}else{$rEmbarazo = mb_strtoupper(sqlValue($_POST["Rembarazo_m"], "text"));}
if(empty($_POST['grupoMedico_m'])){$gMedico =  "NULL";}else{$gMedico = mb_strtoupper(sqlValue($_POST["grupoMedico_m"], "text"));}
if(empty($_POST['via_administracion_m'])){$via_admin =  "NULL";}else{$via_admin = mb_strtoupper(sqlValue($_POST["via_administracion_m"], "text"));}
if(empty($_POST['contenido_m'])){$contenido =  "NULL";}else{$contenido = mb_strtoupper(sqlValue($_POST["contenido_m"], "text"));}
if(empty($_POST['generalidades_m'])){$generalidades =  "NULL";}else{$generalidades = mb_strtoupper(sqlValue($_POST["generalidades_m"], "text"));}
if(empty($_POST['efectos_m'])){$efectos =  "NULL";}else{$efectos = mb_strtoupper(sqlValue($_POST["efectos_m"], "text"));}
if(empty($_POST['contradicciones_m'])){$contradicciones =  "NULL";}else{$contradicciones = mb_strtoupper(sqlValue($_POST["contradicciones_m"], "text"));}
if(empty($_POST['interacciones_m'])){$interacciones =  "NULL";}else{$interacciones = mb_strtoupper(sqlValue($_POST["interacciones_m"], "text"));}
if(empty($_POST['indicaciones_m'])){$indicaciones =  "NULL";}else{$indicaciones = mb_strtoupper(sqlValue($_POST["indicaciones_m"], "text"));}
if(empty($_POST['via_admin_dosis_m'])){$via_admin_dosis =  "NULL";}else{$via_admin_dosis = mb_strtoupper(sqlValue($_POST["via_admin_dosis_m"], "text"));}
if(empty($_POST['presentaciones_m'])){$presentaciones =  "NULL";}else{$presentaciones = mb_strtoupper(sqlValue($_POST["presentaciones_m"], "text"));}
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 //max_min stock
if(empty($_POST['min_stock'])){$min_stock = 0;}else{$min_stock = mb_strtoupper(sqlValue($_POST["min_stock"], "int"));}
if(empty($_POST['max_stock'])){$max_stock = 0;}else{$max_stock = mb_strtoupper(sqlValue($_POST["max_stock"], "int"));}

 mysql_select_db($database_horizonte, $horizonte);
 $sql = "UPDATE medicamentos set clave_med = $clave_m, nombre_generico_med = $nombre, descripcion_med = $descripcion, cantidad_med = $cantidad, presentacion_med = $presentacion, nivel_med = $nivel, grupo_med = $gMedico, generalidades_med = $generalidades, riesgo_embarazo_med = $rEmbarazo, efectos_adversos_med = $efectos, contraindicaciones_precauciones_med = $contradicciones, interacciones_med = $interacciones, indicaciones_med = $indicaciones, via_administracion_dosis_med = $via_admin_dosis, via_administracion_med = $via_admin, contenido_med = $contenido, presentaciones_med = $presentaciones,fecha_med =$now, m_min_stock = $min_stock, m_max_stock = $max_stock where id_med = $idP limit 1";
// echo($sql);
 $update = mysql_query($sql, $horizonte) or die (mysql_error());    
	
 if(!$update){echo $sql;} else{echo 1;}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>