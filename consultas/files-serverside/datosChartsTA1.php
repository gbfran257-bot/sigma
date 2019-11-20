<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	$idP = sqlValue($_POST["idP"], "int");
	$idSV = sqlValue($_POST["idSV"], "int");
		
	$lista = ''; $lista1 = ''; $cont = 0; $vI = ''; $vF = '';
	$lista_1 = ''; $lista1_1 = ''; $cont_1 = 0; $vI_1 = ''; $vF_1 = '';
	
	mysql_select_db($database_horizonte, $horizonte);
	//$consulta = "SELECT TRUNCATE( (t_sv/a_sv), 2) as x, DATE_FORMAT(fecha_sv,'%d/%c/%Y') as fecha, peso_sv, DATE_FORMAT(fecha_sv,'%Y-%c-%d') as fecha1 from signos_vitales where id_paciente_sv = $idP and id_sv <= $idSV order by id_sv asc limit 50";
	$consulta = "SELECT TRUNCATE( (t_sv), 2) as x, DATE_FORMAT(fecha_sv,'%d/%c/%Y') as fecha, peso_sv, DATE_FORMAT(fecha_sv,'%Y-%c-%d') as fecha1, TRUNCATE( (a_sv), 2) as x1 from signos_vitales where id_paciente_sv = $idP and id_sv <= $idSV order by id_sv asc limit 50";
	$query = mysql_query($consulta) or die (mysql_error());
	
	while ($fila = mysql_fetch_array($query)) { $cont++;
		//Para T
		if($cont==1){$lista = $fila['x'];}else{$lista = $lista.','.$fila['x'];}
		if($cont==1){$lista1 = $fila['fecha'];}else{$lista1 = $lista1.','.$fila['fecha'];}
		
		//Para A
		if($cont==1){$lista_1 = $fila['x1'];}else{$lista_1 = $lista_1.','.$fila['x1'];}
		if($cont==1){$lista1_1 = $fila['fecha'];}else{$lista1_1 = $lista1_1.','.$fila['fecha'];}
		
		$miF = $fila['fecha1'];
		mysql_select_db($database_horizonte, $horizonte); 
		$resultC = mysql_query("SELECT DATEDIFF('$miF',fNac_p), sexo_p from pacientes where id_p = $idP ", $horizonte) or die (mysql_error());
		$rowC = mysql_fetch_row($resultC); $dias = $rowC[0];
		$edad = $dias/365; $peso = $fila['peso_sv'];
		
		//Para hombres y mujeres 
		if($edad==0){
			//Para T
			if( $peso < 1 ){$vMin = 39; $vMax = 59;}
			if( $peso >= 2.5 and $peso <= 4 ){$vMin = 50; $vMax = 75;}
			if( $peso >= 4 and $peso <= 10 ){$vMin = 80; $vMax = 100;}
			//Para A
			if( $peso < 1 ){$vMin_1 = 16; $vMax_1 = 36;}
			if( $peso >= 2.5 and $peso <= 4 ){$vMin_1 = 30; $vMax_1 = 50;}
			if( $peso >= 4 and $peso <= 10 ){$vMin_1 = 45; $vMax_1 = 65;}
		}
		if($edad>=1 and $edad <=2){
			//Para T
			$vMin = 80; $vMax = 105;
			//Para A
			$vMin_1 = 45; $vMax_1 = 70;
		}
		if($edad>=2 and $edad <=6){
			//Para T
			$vMin = 80; $vMax = 120;
			//Para A
			$vMin_1 = 50; $vMax_1 = 80;
		}
		if($edad>=6 and $edad<=10){
			//Para T
			$vMin = 85; $vMax = 130;
			//Para A
			$vMin_1 = 55; $vMax_1 = 90;
		}
		if($edad>=10 and $edad<=14){
			//Para T
			$vMin = 90; $vMax = 140;
			//Para A
			$vMin_1 = 60; $vMax_1 = 95;
		}
		if($edad>14){
			//Para T
			$vMin = 90; $vMax = 140;
			//Para A
			$vMin_1 = 60; $vMax_1 = 95;
		}
		
		//Para T
		if($cont==1){$vI = $vMin;}else{$vI = $vI.','.$vMin;}
		if($cont==1){$vF = $vMax;}else{$vF = $vF.','.$vMax;}
		//Para A
		if($cont==1){$vI_1 = $vMin_1;}else{$vI_1 = $vI_1.','.$vMin_1;}
		if($cont==1){$vF_1 = $vMax_1;}else{$vF_1 = $vF_1.','.$vMax_1;}
		
	};
			
	echo $lista1.';*'.$lista.';*'.$cont.';*'.$vI.';*'.$vF.';*'.$lista1_1.';*'.$lista_1.';*'.$cont.';*'.$vI_1.';*'.$vF_1;
 	//Cerrar conexión a la Base de Datos
 	mysql_close($horizonte);
?>