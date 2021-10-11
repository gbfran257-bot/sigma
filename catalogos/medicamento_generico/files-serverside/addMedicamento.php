<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 
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
$noTemp = sqlValue(date('Y-m-d-H-i-s'), "date");

    mysql_select_db($database_horizonte, $horizonte);
 	
    $sql = "INSERT INTO medicamentos (clave_med, nombre_generico_med, descripcion_med, cantidad_med, presentacion_med, nivel_med, grupo_med, generalidades_med, riesgo_embarazo_med, efectos_adversos_med, contraindicaciones_precauciones_med, interacciones_med, indicaciones_med, via_administracion_dosis_med, via_administracion_med, contenido_med, presentaciones_med, fecha_med) VALUES "; 
    
    $sql .= "($clave_m, $nombre, $descripcion, $cantidad, $presentacion, $nivel, $gMedico, $generalidades, $rEmbarazo, $efectos, $contradicciones, $interacciones, $indicaciones, $via_admin_dosis, $via_admin, $contenido, $presentaciones, $now)";

    $update = mysql_query($sql, $horizonte) or die (mysql_error());

    if (!$update) {echo $sql;} else{ echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>