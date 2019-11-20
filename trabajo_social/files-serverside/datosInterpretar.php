<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idE = sqlValue($_POST["idE"], "int");

	mysql_select_db($database_horizonte, $horizonte);
  
	$result = mysql_query("SELECT referencia_vc, interpretacion_vc, nota_interpretacion, date_format(fecha_venta_vc,'%d/%c/%Y'), id_paciente_vc, id_personal_medico_vc, id_concepto_es, usuarioEdo4_e, contador_vc, area_vc, nota_radiologo_vc from venta_conceptos where id_vc = $idE ", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result);
	
	mysql_select_db($database_horizonte, $horizonte);
  
	$result1 = mysql_query("SELECT fNac_p, sexo_p, concat(nombre_p, ' ', apaterno_p), amaterno_p from pacientes where id_p = $row[4] ", $horizonte) or die (mysql_error());
 	$row1 = mysql_fetch_row($result1);
	
	$result2 = mysql_query("SELECT nombre_u, apaterno_u, amaterno_u from usuarios where id_u = $row[5] ", $horizonte) or die (mysql_error());
 	$row2 = mysql_fetch_row($result2);
	
	$result3 = mysql_query("SELECT nombre_est from estudios where id_est = $row[6] ", $horizonte) or die (mysql_error());
 	$row3 = mysql_fetch_row($result3);
	
	$result4 = mysql_query("SELECT nombre_u, apaterno_u, amaterno_u, cedulaProfesional_u, id_u from usuarios where id_u = $row[5] ", $horizonte) or die (mysql_error());
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
	if($row[9] == 2){
		$referenciaPacs = $row[0];
	}else{$referenciaPacs = $row[0]."-".$row[8];}
	
	$datos = $nombre.';*-'.$row[0].';*-'.$row1[0].';*-'.$row1[1].";*-".$row[3].";*-".$row[1].";*-".$row[2].";*-".$medicoEstudio.";*-".$row3[0].";*-".$medicoInterpreta.";*-".$row4[3].";*-".$row[7].".png".";*-".$referenciaPacs.";*-".$row[10];
	
echo $datos;
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>