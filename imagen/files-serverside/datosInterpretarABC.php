<?php
require("../../Connections/horizonte.php");
require("../../Connections/ipacs.php");
require("../../funciones/php/values.php");

 $idE = sqlValue($_POST["idE1"], "int");

	mysql_select_db($database_horizonte, $horizonte);
  
	$result = mysql_query("SELECT referencia_vc, interpretacion_vc, nota_interpretacion, date_format(fecha_venta_vc,'%d/%c/%Y'), id_paciente_vc, id_personal_medico_vc, id_concepto_es, usuarioEdo5_e, contador_vc, area_vc, nota_radiologo_vc, usuarioEdo5_e from venta_conceptos where id_vc = $idE ", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result);
	
	mysql_select_db($database_horizonte, $horizonte);
  
	$result1 = mysql_query("SELECT fNac_p, sexo_p, concat(nombre_p, ' ', apaterno_p), amaterno_p, date_format(fNac_p,'%d/%c/%Y') from pacientes where id_p = $row[4] ", $horizonte) or die (mysql_error());
 	$row1 = mysql_fetch_row($result1);
	
	$result2 = mysql_query("SELECT nombre_u, apaterno_u, amaterno_u from usuarios where id_u = $row[5] ", $horizonte) or die (mysql_error());
 	$row2 = mysql_fetch_row($result2);
	
	$result3 = mysql_query("SELECT concepto_to from conceptos where id_to = $row[6] ", $horizonte) or die (mysql_error());
 	$row3 = mysql_fetch_row($result3);
	
	$idUi = sqlValue($row[11], "int");
	$result4 = mysql_query("SELECT nombre_u, apaterno_u, amaterno_u, cedulaProfesional_u, id_u, sexo_u from usuarios where id_u = $idUi ", $horizonte) or die (mysql_error());
 	$row4 = mysql_fetch_row($result4);
	
	//para la edad
			$fecha1 = new DateTime($row1[0]);
			$fecha2 = new DateTime(date("Y-m-d H:i:s"));
			$fecha = $fecha1->diff($fecha2);
			//printf('%d AÑOS %d MESES %d DÍAS %d HORAS %d MINUTOS', $fecha->y, $fecha->m, $fecha->d, $fecha->h, $fecha->i);
			$anos=$fecha->y;
			$meses=$fecha->m;
			$dias=$fecha->d;
			$horas=$fecha->h;
			$minutos=$fecha->i;
			if($anos>0){$row1[0]=$anos." AÑOS";}
			if($anos<1){
				if($meses<=2 and $meses>=1){$row1[0]=$meses." MES(ES) ".$dias." DÍA(S)";}
				if($meses>=3){$row1[0]=$meses." MES(ES) ";}
				if($meses==0){$row1[0]=$dias." DÍA(S)";}
				if($meses==0 and $dias<=1){$row1[0]=$dias." DÍA(S) ".$horas." HORA(S)";}
				if($meses==0 and $dias<1){$row1[0]=$horas." HORA(S) ".$minutos." MINUTO(S)";}
			} 
			if($anos>150 or $anos<0){$row1[0]="DESCONOCIDA";}
		//para el sexo
				switch($row1[1]){
				case 1:
					$row1[1] = "FEMENINO";
					break;
				case 2:
					$row1[1] = "MASCULINO";
					break;
				case 3:
					$row1[1] = "AMBIGUO";
					break;
				case 4:
					$row1[1] = "NO APLICA";
					break;
				case 99:
					$row1[1] = "SIN ASIGNACIÓN";
					break;
				}
	
	$nombre = $row1[2].' '.$row1[3];
	$medicoEstudio = $row2[0]." ".$row2[1]." ".$row2[2];
	$medicoInterpreta = $row4[0]." ".$row4[1]." ".$row4[2];
	if($row[9] != 55){
		$referenciaPacs = $row[0];
	}else{$referenciaPacs = $row[0]."-".$row[8];}
	
	$referenciaPacs = substr($referenciaPacs, 2);
	$referenciaPacs = str_replace("-","",$referenciaPacs);
	
	$idPP = sqlValue($referenciaPacs, "text");
	
	//Seleccionamos el id del paciente en la tabla patient de la DB del ipacs
	mysql_select_db($database_ipacs, $ipacs);
  
	$resultP1 = mysql_query("SELECT pk from patient where pat_id = 'rat gold' ", $ipacs) or die (mysql_error());
 	$rowP1 = mysql_fetch_row($resultP1); $idPP1 = sqlValue($rowP1[0], "int");//Is id de patient $idPP
	
	//Seleccionamos el número de imágenes en el estudio completo de la DB del ipacs
	mysql_select_db($database_ipacs, $ipacs);
  
	$resultNI = mysql_query("SELECT num_instances from study where patient_fk = $idPP1 ", $ipacs) or die (mysql_error());
 	$rowNI = mysql_fetch_row($resultNI); $ni = sqlValue($rowNI[0], "int");
	
	$i = 0; $j=0;
	$lista = '';
	
	//Seleccionamos el study_iuid de la tabla de study del ipacs para pasarlo al osirix
	mysql_select_db($database_ipacs, $ipacs);
  
	$consulta = "SELECT i.sop_iuid as mi, s.series_iuid as ms, e.study_iuid as me from instance i left join series s on s.pk = i.series_fk left join study e on e.pk = s.study_fk left join patient p on p.pk = e.patient_fk where p.pk = $idPP1";
	$query = mysql_query($consulta) or die (mysql_error());
	
	$c = 0;
	while ($fila = mysql_fetch_array($query)) { $c++;

		$lista = $lista.'"'.'osirix://?methodName=DownloadURL&amp;Display=YES&amp;URL='."'".'http://manantiales.no-ip.biz:8080/wado?requestType=WADO&studyUID='.$fila['me'].'&seriesUID='.$fila['ms'].'&objectUID='.$fila['mi'].'&contentType=application%2Fdicom&transferSyntax=1.2.840.10008.1.2.1'."'".'"*';
	};
	
	$datos = $nombre.';*-'.$row[0].';*-'.$row1[0].';*-'.$row1[1].";*-".$row[3].";*-".$row[1].";*-".$row[2].";*-".$medicoEstudio.";*-".$row3[0].";*-".$medicoInterpreta.";*-".$row4[3].";*-".$row[7].".png".";*-".$referenciaPacs.";*-".$row[10].";*-".$row1[4].";*-".$row4[5].";*-".$ni.";*-".$lista;
	
echo $datos;
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
 mysql_close($ipacs);
?>