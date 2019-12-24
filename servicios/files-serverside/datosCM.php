<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php"); //CONSIDERANDOLO CLINICAMENTE SANO

 	$idC = sqlValue($_POST["idC"], "int");
	
	mysql_select_db($database_horizonte, $horizonte);
	$result = mysql_query("SELECT m.nombre_u, m.apaterno_u, m.amaterno_u, t.abreviacion_ti, cedulaProfesional_u, p.sexo_p, p.fNac_p, p.nombre_p, p.apaterno_p, p.amaterno_p, p.id_p, s.tipo_sangre, su.municipio_su, su.estado_su from venta_conceptos v left join usuarios m on m.id_u = v.usuarioEdo2_e left join pacientes p on p.id_p = v.id_paciente_vc left join catalogo_tipo_sangre s on s.id_tipo_sangre = p.tSanguineo_p left join titulos t on t.id_ti = m.titulo_u left join orden_venta o on o.referencia_ov = v.referencia_vc left join sucursales su on su.id_su = o.sucursal_ov where v.id_vc = $idC ", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result);
	
	$fecha1 = new DateTime($row[6]); $fecha2 = new DateTime(date("Y-m-d H:i:s")); $fecha = $fecha1->diff($fecha2);
	//printf('%d AÑOS %d MESES %d DÍAS %d HORAS %d MINUTOS', $fecha->y, $fecha->m, $fecha->d, $fecha->h, $fecha->i);
	$anos=$fecha->y; $meses=$fecha->m; $dias=$fecha->d; $horas=$fecha->h; $minutos=$fecha->i; $segundos=$fecha->s;
	if($anos>0){$rowX=$anos." AÑOS";}
	if($anos<1){
		if($meses<=2 and $meses>=1){$rowX=$meses." MES(ES) ".$dias." DÍA(S)";}
		if($meses>=3){$rowX=$meses." MES(ES) ";}
		if($meses==0){$rowX=$dias." DÍA(S)";}
		if($meses==0 and $dias<=1){$rowX=$dias." DÍA(S) ".$horas." HORA(S)";}
		if($meses==0 and $dias<1){$rowX=$horas." HORA(S) ".$minutos." MINUTO(S)";}
	}
	
	mysql_select_db($database_horizonte, $horizonte);
	$resultSV = mysql_query("SELECT peso_sv,talla_sv, imc_sv, cintura_sv, t_sv, a_sv, fr_sv, fc_sv, temperatura_sv, notas_sv, DATE_FORMAT(fecha_sv,'%d/%c/%Y %H:%i:%s'), id_sv from signos_vitales where id_paciente_sv = $row[10] order by id_sv desc limit 1", $horizonte) or die (mysql_error());
 	$rowSV = mysql_fetch_row($resultSV);
	
	$medico = $row[3].' '.$row[0].' '.$row[1].' '.$row[2];
	$paciente = $row[7].' '.$row[8].' '.$row[9];
	
	if($row[5]==1){$elola= 'LA'; $ciuda = 'CIUDADANA'; $sanoa = 'SANA'; $considerandoloa = 'CONSIDERÁNDOLA CLÍNICAMENTE ';}
	else{$elola = 'EL'; $ciuda = 'CIUDADANO'; $sanoa = 'SANO';$considerandoloa = 'CONSIDERÁNDOLO CLÍNICAMENTE ';}
	
	if($anos<18){$menor = 'MENOR';}else{$menor = $ciuda;}
	
	$choro = $elola.' '.$menor.' '.$paciente.' DE '.$anos.' AÑOS '.$meses.' MESES DE EDAD '.$elola.' CUAL A LA EXPLORACIÓN FÍSICA SE ENCUENTRA CLÍNICAMENTE '.$sanoa;
	
	$signos = 'TEMP '.$rowSV[8].' ºC, TALLA '.$rowSV[1].' mts, PESO '.$rowSV[0].' kg, IMC '.$rowSV[2];
	
	if(date("m")=='01'){ $mes="ENERO"; }else if(date("m")=='02'){$mes="FEBRERO";}else if(date("m")=='03'){$mes="MARZO";}else if(date("m")=='04'){$mes="ABRIL";}else if(date("m")=='05'){$mes="MAYO";}else if(date("m")=='06'){$mes="JUNIO";}else if(date("m")=='07'){$mes="JULIO";}else if(date("m")=='08'){$mes="AGOSTO";}else if(date("m")=='09'){$mes="SEPTIEMBRE";}else if(date("m")=='10'){$mes="OCTUBRE";}else if(date("m")=='11'){$mes="NOVIEMBRE";}else if(date("m")=='12'){$mes="DICIEMBRE";}
	
	$fechaCe = $row[12].", ".$row[13]." A ".date("j")." DE ".$mes." DEL ".date("Y");
	
	echo $medico.';}{*'.$row[4].';}{*'.$choro.';}{*'.$signos.';}{*'.$row[11].';}{*'.$considerandoloa.$sanoa.';}{*'.$fechaCe.';}{*'.$row[11].';}{*'.$row[11];
 	//Cerrar conexión a la Base de Datos
 	mysql_close($horizonte);
?>