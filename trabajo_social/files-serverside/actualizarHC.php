<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idP = sqlValue($_POST["idPaciente_hc"], "int");
 $idU = sqlValue($_POST["idUsuario_hc"], "int");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 $estatus_padre = sqlValue($_POST["estatus_padre"], "int");
 $enfermedad_padre_1 = sqlValue($_POST["ahf_padre_1"], "int");
 $enfermedad_padre_2 = sqlValue($_POST["ahf_padre_2"], "int");
 $enfermedad_padre_3 = sqlValue($_POST["ahf_padre_3"], "int");
 $enfermedad_padre_4 = sqlValue($_POST["ahf_padre_4"], "int");
 $estatus_madre = sqlValue($_POST["estatus_madre"], "int");
 $enfermedad_madre_1 = sqlValue($_POST["ahf_madre_1"], "int");
 $enfermedad_madre_2 = sqlValue($_POST["ahf_madre_2"], "int");
 $enfermedad_madre_3 = sqlValue($_POST["ahf_madre_3"], "int");
 $enfermedad_madre_4 = sqlValue($_POST["ahf_madre_4"], "int");
 $noHnos = sqlValue($_POST["noHnos"], "int");
 $enfermedad_hnos_1 = sqlValue($_POST["ahf_hnos_1"], "int");
 $enfermedad_hnos_2 = sqlValue($_POST["ahf_hnos_2"], "int");
 $enfermedad_hnos_3 = sqlValue($_POST["ahf_hnos_3"], "int");
 $enfermedad_hnos_4 = sqlValue($_POST["ahf_hnos_4"], "int");
 $estatus_conyugue = sqlValue($_POST["estatus_conyugue"], "int");
 $enfermedad_conyugue_1 = sqlValue($_POST["ahf_conyugue_1"], "int");
 $enfermedad_conyugue_2 = sqlValue($_POST["ahf_conyugue_2"], "int");
 $enfermedad_conyugue_3 = sqlValue($_POST["ahf_conyugue_3"], "int");
 $enfermedad_conyugue_4 = sqlValue($_POST["ahf_conyugue_4"], "int");
 $noHijos = sqlValue($_POST["noHijos"], "int");
 $enfermedad_hijos_1 = sqlValue($_POST["ahf_hijos_1"], "int");
 $enfermedad_hijos_2 = sqlValue($_POST["ahf_hijos_2"], "int");
 $enfermedad_hijos_3 = sqlValue($_POST["ahf_hijos_3"], "int");
 $enfermedad_hijos_4 = sqlValue($_POST["ahf_hijos_4"], "int");
 $ahf_notas = sqlValue($_POST["ahf_notas"], "text");
 
 $adiccion1 = sqlValue($_POST["adiccion1"], "int");
 $adiccion2 = sqlValue($_POST["adiccion2"], "int");
 $adiccion3 = sqlValue($_POST["adiccion3"], "int");
 $deporte1 = sqlValue($_POST["deporte1"], "int");
 $deporte2 = sqlValue($_POST["deporte2"], "int");
 $inicio_adiccion1 = sqlValue($_POST["inicio_adiccion1"], "int");
 $inicio_adiccion2 = sqlValue($_POST["inicio_adiccion2"], "int");
 $inicio_adiccion3 = sqlValue($_POST["inicio_adiccion3"], "int");
 $frecuencia_deporte1 = sqlValue($_POST["frecuencia_deporte1"], "int");
 $frecuencia_deporte2 = sqlValue($_POST["frecuencia_deporte2"], "int");
 $frecuencia_adiccion1 = sqlValue($_POST["frecuencia_adiccion1"], "int");
 $frecuencia_adiccion2 = sqlValue($_POST["frecuencia_adiccion2"], "int");
 $frecuencia_adiccion3 = sqlValue($_POST["frecuencia_adiccion3"], "int");
 $recreacion1 = sqlValue($_POST["recreacion1"], "int");
 $recreacion2 = sqlValue($_POST["recreacion2"], "int");
 $recreacion3 = sqlValue($_POST["recreacion3"], "int");
 $recreacion4 = sqlValue($_POST["recreacion4"], "int");
 $recreacion5 = sqlValue($_POST["recreacion5"], "int");
 $recreacion6 = sqlValue($_POST["recreacion6"], "int");
 $vivienda_hc = sqlValue($_POST["vivienda_hc"], "int");
 $mat_vivienda1 = sqlValue($_POST["mat_vivienda1"], "int");
 $mat_vivienda2 = sqlValue($_POST["mat_vivienda2"], "int");
 $habitantes = sqlValue($_POST["habitantes"], "int");
 $servicios1_hc = sqlValue($_POST["servicios1_hc"], "int");
 $servicios2_hc = sqlValue($_POST["servicios2_hc"], "int");
 $servicios3_hc = sqlValue($_POST["servicios3_hc"], "int");
 $servicios4_hc = sqlValue($_POST["servicios4_hc"], "int");
 $aseo_personal = sqlValue($_POST["aseo_personal"], "int");
 $vacunas1 = sqlValue($_POST["vacunas1"], "int");
 $vacunas2 = sqlValue($_POST["vacunas2"], "int");
 $vacunas3 = sqlValue($_POST["vacunas3"], "int");
 $observacionesVacunas = sqlValue($_POST["observacionesVacunas"], "text");
 $hrs_dormir = sqlValue($_POST["hrs_dormir"], "int");
 $alimentacion_hc = sqlValue($_POST["alimentacion_hc"], "int");
 $mascota1 = sqlValue($_POST["mascota1"], "int");
 $mascota2 = sqlValue($_POST["mascota2"], "int");
 $enfermedad1 = sqlValue($_POST["enfermedad1"], "int");
 $enfermedad2 = sqlValue($_POST["enfermedad2"], "int");
 $enfermedad3 = sqlValue($_POST["enfermedad3"], "int");
 $enfermedad4 = sqlValue($_POST["enfermedad4"], "int");
 $cirugia1 = sqlValue($_POST["cirugia1"], "text");
 $cirugia2 = sqlValue($_POST["cirugia2"], "text");
 $cirugia3 = sqlValue($_POST["cirugia3"], "text");
 $transfusiones = sqlValue($_POST["transfusiones"], "int");
 $app_notas = sqlValue($_POST["app_notas"], "text");
 $menarca = sqlValue($_POST["menarca"], "int");
 
 $ritmo = sqlValue($_POST["ritmo"], "int");
 $duracionR = sqlValue($_POST["duracionR"], "int");
 $fur = sqlValue($_POST["fur"], "text");
 $ivsa = sqlValue($_POST["ivsa"], "int");
 $gestas = sqlValue($_POST["gestas"], "int");
 $partos = sqlValue($_POST["partos"], "int");
 $cesareas = sqlValue($_POST["cesareas"], "int");
 $abortos = sqlValue($_POST["abortos"], "int");
 $anticonceptivo = sqlValue($_POST["anticonceptivo"], "int");
 $tipo_anticon = sqlValue($_POST["tipo_anticon"], "int");
 $tiempo_uso = sqlValue($_POST["tiempo_uso"], "int");
 $doc = sqlValue($_POST["doc"], "text");
 $colposcopiaHC = sqlValue($_POST["colposcopiaHC"], "text");
 $mastografiaHC = sqlValue($_POST["mastografiaHC"], "text");
 $ago_notas = sqlValue($_POST["ago_notas"], "text");
 $apnp_notas = sqlValue($_POST["apnp_notas"], "text");
 
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "UPDATE historia_clinica SET estatus_padre_hc = $estatus_padre, ahf_padre_1 = $enfermedad_padre_1, ahf_padre_2 = $enfermedad_padre_2, ahf_padre_3 = $enfermedad_padre_3, ahf_padre_4 = $enfermedad_padre_4, estatus_madre_hc = $estatus_madre, ahf_madre_1 = $enfermedad_madre_1, ahf_madre_2 = $enfermedad_madre_2, ahf_madre_3 = $enfermedad_madre_3, ahf_madre_4 = $enfermedad_madre_4, no_hermanos = $noHnos, ahf_hnos_1 = $enfermedad_hnos_1, ahf_hnos_2 = $enfermedad_hnos_2, ahf_hnos_3 = $enfermedad_hnos_3, ahf_hnos_4 = $enfermedad_hnos_4, estatus_conyugue = $estatus_conyugue, ahf_conyugue_1 = $enfermedad_conyugue_1, ahf_conyugue_2 = $enfermedad_conyugue_2, ahf_conyugue_3 = $enfermedad_conyugue_3, ahf_conyugue_4 = $enfermedad_conyugue_4, no_hijos_hc = $noHijos, ahf_hijos_1 = $enfermedad_hijos_1, ahf_hijos_2 = $enfermedad_hijos_2, ahf_hijos_3 = $enfermedad_hijos_3, ahf_hijos_4 = $enfermedad_hijos_4, adiccion1 = $adiccion1, adiccion2 = $adiccion2, adiccion3 = $adiccion3, inicio_adiccion1 = $inicio_adiccion1, inicio_adiccion2 = $inicio_adiccion2, inicio_adiccion3 = $inicio_adiccion3, frecuencia_adiccion1 = $frecuencia_adiccion1, frecuencia_adiccion2 = $frecuencia_adiccion2, frecuencia_adiccion3 = $frecuencia_adiccion3, deporte1 = $deporte1, deporte2 = $deporte2, frecuencia_deporte1 = $frecuencia_deporte1, frecuencia_deporte2 = $frecuencia_deporte2, apnp_notas = $apnp_notas, recreacion1 = $recreacion1, recreacion2 = $recreacion2, recreacion3 = $recreacion3, recreacion4 = $recreacion4, recreacion5 = $recreacion5, recreacion6 = $recreacion6, vivienda_hc = $vivienda_hc, habitantes_hc = $habitantes, mat_vivienda1 = $mat_vivienda1, mat_vivienda2 = $mat_vivienda2, servicios1 = $servicios1_hc, servicios2 = $servicios2_hc, servicios3 = $servicios3_hc, servicios4 = $servicios4_hc, aseo_personal_hc = $aseo_personal, vacunas1 = $vacunas1, vacunas2 = $vacunas2, vacunas3 = $vacunas3, observaciones_app_hc = $observacionesVacunas, horas_dormir_hc = $hrs_dormir, alimentacion_hc = $alimentacion_hc, mascotas1_hc = $mascota1, mascotas2_hc = $mascota2, enfermedad1 = $enfermedad1, enfermedad2 = $enfermedad2, enfermedad3 = $enfermedad3, enfermedad4 = $enfermedad4, cirugia1 = $cirugia1, cirugia2 = $cirugia2, cirugia3 = $cirugia3, transfusiones_hc = $transfusiones, app_notas = $app_notas, menarca_hc = $menarca, ritmo_hc = $ritmo, duracion_hc = $duracionR, fur_hc = $fur, ivsa_hc = $ivsa, gestas_hc = $gestas, partos_hc = $partos, cesareas_hc = $cesareas, abortos_hc = $abortos, anticonceptivo_hc = $anticonceptivo, tipo_anticonceptivo_hc = $tipo_anticon, tiempo_uso_hc = $tiempo_uso, doc_hc = $doc, colposcopia_hc = $colposcopiaHC, mastografia_hc = $mastografiaHC, ago_notas_hc = $ago_notas, fecha_registro_hc = $now, id_usuario_hc = $idU, temporal_hc = 0, ahf_notas = $ahf_notas where id_paciente_hc = $idP limit 1";
   
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) { echo $sql; }else { echo 1; }

 mysql_close($horizonte); //Cerrar conexión a la Base de Datos
?>