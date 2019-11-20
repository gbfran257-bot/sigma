<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	$noAleatorio = sqlValue($_POST["noAleatorio"], "text");

	mysql_select_db($database_horizonte, $horizonte);
	$result = mysql_query("SELECT id_paciente_vc, nota_receta from venta_conceptos where no_temp_vc = $noAleatorio and tipo_concepto_vc = 1 ", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result); $idP = sqlValue($row[0], "int");
	
	mysql_select_db($database_horizonte, $horizonte);
	$result1 = mysql_query("SELECT nombre_p, apaterno_p, amaterno_p, fNac_p, sexo_p from pacientes where id_p = $idP ", $horizonte) or die (mysql_error());
 	$row1 = mysql_fetch_row($result1); $fx = $row1[3];
	
	//para la edad
	$fecha1 = new DateTime($fx); $fecha2 = new DateTime(date("Y-m-d H:i:s")); $fecha = $fecha1->diff($fecha2);

	$anos=$fecha->y; $meses=$fecha->m; $dias=$fecha->d; $horas=$fecha->h; $minutos=$fecha->i; $segundos=$fecha->s;
	if($anos>0){$fx=$anos." AÑOS";}
	if($anos<1){
		if($meses<=2 and $meses>=1){$fx=$meses." MES(ES) ".$dias." DÍA(S)";}
		if($meses>=3){$fx=$meses." MES(ES) ";}
		if($meses==0){$fx=$dias." DÍA(S)";}
		if($meses==0 and $dias<=1){$fx=$dias." DÍA(S) ".$horas." HORA(S)";}
		if($meses==0 and $dias<1){$fx=$horas." HORA(S) ".$minutos." MINUTO(S)";}
	} 
	if($anos>150 or $anos<0){$fx="DESCONOCIDA";}else{}
	
	//para el sexo
	switch($row1[4]){
		case 1: $row1[4] = "FEMENINO"; break;
		case 2: $row1[4] = "MASCULINO"; break;
		case 3: $row1[4] = "AMBIGUO"; break;
		case 4: $row1[4] = "NO APLICA"; break;
		case 99: $row1[4] = "SIN ASIGNACIÓN"; break;
	}
	
	mysql_select_db($database_horizonte, $horizonte);
	$result2 = mysql_query("SELECT peso_sv, talla_sv, imc_sv, cintura_sv, temperatura_sv, t_sv, a_sv, fr_sv, fc_sv from signos_vitales where id_paciente_sv = $idP order by id_sv desc limit 1 ", $horizonte) or die (mysql_error());
 	$row2 = mysql_fetch_row($result2);
	
	mysql_select_db($database_horizonte, $horizonte);
	$result3 = mysql_query("SELECT id_personal_medico_vc from venta_conceptos where no_temp_vc = $noAleatorio and tipo_concepto_vc = 1 limit 1 ", $horizonte) or die (mysql_error());
 	$row3 = mysql_fetch_row($result3);
	
	$idMedico = sqlValue($row3[0], "int");
	
	mysql_select_db($database_horizonte, $horizonte);
	$result4 = mysql_query("SELECT sexo_u, nombre_u, apaterno_u, amaterno_u, cedulaProfesional_u, especialidad_u from usuarios where id_u = $idMedico ", $horizonte) or die (mysql_error());
 	$row4 = mysql_fetch_row($result4); $idEsp = sqlValue($row4[5], "int");
	
	mysql_select_db($database_horizonte, $horizonte);
	$result4x = mysql_query("SELECT nombre_especialidad from especialidades where id_es = $idEsp ", $horizonte) or die (mysql_error());
 	$row4x = mysql_fetch_row($result4x); 
	
	$lista = ''; $contador = 1;
	mysql_select_db($database_horizonte, $horizonte);
	$consulta = "SELECT id_med_mr, cantidad_mr, unidad_mr, periodicidad_mr, duracion_mr from medicamentos_receta where no_temp_mr = $noAleatorio ";
	$query = mysql_query($consulta) or die (mysql_error());
	while ($fila = mysql_fetch_array($query)) { $idMedi = sqlValue($fila['id_med_mr'], "int"); $idUni = sqlValue($fila['unidad_mr'], "int");
		$result5 = mysql_query("SELECT nombre_generico_med, descripcion_med, cantidad_med from medicamentos where id_med = $idMedi ", $horizonte) or die (mysql_error());
 		$row5 = mysql_fetch_row($result5);
		
		$result6 = mysql_query("SELECT unidad_un from unidades where id_un = $idUni ", $horizonte) or die (mysql_error());
 		$row6 = mysql_fetch_row($result6);
		
		$lista = $lista.'<tr>'.'<td width="1%" nowrap><strong>'.$contador.'.-</strong></td>'.'<td>'.$row5[0].'</td>'.'<td>'.$row5[1].'</td>'.'<td>'.$row5[2].'</td>'.'<td nowrap>'.$fila['cantidad_mr'].'</td>'.'<td nowrap>'.$row6[0].'</td>'.'<td nowrap>'.$fila['periodicidad_mr'].'</td>'.'<td nowrap>'.$fila['duracion_mr'].'</td>'.'</tr>'; $contador++;
	};$lista = '<table width="100%" height="100%" border="0" cellspacing="2" cellpadding="2" style="font-size:0.75em;">'.$lista.'</table>';
	
	if($row4[0]==1){$sexoDR='DRA.';}else{$sexoDR = 'DR.';}
	$nombreM = $row4[1].' '.$row4[2].' '.$row4[3];
		
	$nombre = $row1[0].' '.$row1[1].' '.$row1[2]; 
	
	$now = date('d/m/Y');
	
	$datos = $nombre.';*-'.$fx.';*-'.$row1[4].';*-'.$row2[0].';*-'.$row2[1].';*-'.$row2[2].';*-'.$row2[3].';*-'.$row2[4].';*-'.$row2[5].';*-'.$row2[6].';*-'.$row2[7].';*-'.$row2[8].';*-'.$row[1].';*-'.$sexoDR.';*-'.$nombreM.';*-'.$row4[4].';*-'.$lista.';*-'.$row4x[0].';*-'.$now;
	
	echo $datos;
 	//Cerrar conexión a la Base de Datos
 	mysql_close($horizonte);
?>