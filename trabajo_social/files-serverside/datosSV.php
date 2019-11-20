<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	$idP = sqlValue($_POST["idP"], "int");
	$idC = sqlValue($_POST["idC"], "int");

	mysql_select_db($database_horizonte, $horizonte);
	$result = mysql_query("SELECT nombre_p, apaterno_p, amaterno_p, fNac_p, sexo_p from pacientes where id_p = $idP ", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result); $fx = $row[3];
	
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
	switch($row[4]){
		case 1: $row[4] = "FEMENINO"; break;
		case 2: $row[4] = "MASCULINO"; break;
		case 3: $row[4] = "AMBIGUO"; break;
		case 4: $row[4] = "NO APLICA"; break;
		case 99: $row[4] = "SIN ASIGNACIÓN"; break;
	}
	
	mysql_select_db($database_horizonte, $horizonte);
	$result1 = mysql_query("SELECT peso_sv,talla_sv, imc_sv, cintura_sv, t_sv, a_sv, fr_sv, fc_sv, temperatura_sv, notas_sv, DATE_FORMAT(fecha_sv,'%d/%c/%Y %H:%i:%s') from signos_vitales where id_paciente_sv = $idP order by id_sv desc limit 1", $horizonte) or die (mysql_error());
 	$row1 = mysql_fetch_row($result1);
	
	mysql_select_db($database_horizonte, $horizonte);
	$resultC = mysql_query("SELECT no_temp_vc from venta_conceptos where id_vc = $idC limit 1", $horizonte) or die (mysql_error());
 	$rowC = mysql_fetch_row($resultC);
	$noTC = sqlValue($rowC[0], "text");
	
	mysql_select_db($database_horizonte, $horizonte);
	$resultC1 = mysql_query("SELECT observaciones_vc, nota_interpretacion, nota_receta from venta_conceptos where no_temp_vc = $noTC and tipo_concepto_vc = 1 limit 1", $horizonte) or die (mysql_error());
 	$rowC1 = mysql_fetch_row($resultC1);
	
	$nombre = $row[0].' '.$row[1].' '.$row[2];
	
	$datos = $nombre.';*-'.$fx.';*-'.$row[4].';*-'.$row1[0].';*-'.$row1[1].';*-'.$row1[2].';*-'.$row1[3].';*-'.$row1[4].';*-'.$row1[5].';*-'.$row1[6].';*-'.$row1[7].';*-'.$row1[8].';*-'.$row1[9].';*-'.$row1[10].';*-'.$rowC1[0].';*-'.$rowC1[1].';*-'.$rowC1[2];
	
	echo $datos;
 	//Cerrar conexión a la Base de Datos
 	mysql_close($horizonte);
?>