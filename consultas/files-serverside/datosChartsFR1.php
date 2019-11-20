<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	$idP = sqlValue($_POST["idP"], "int");
	$idSV = sqlValue($_POST["idSV"], "int");
		
	$lista = ''; $lista1 = ''; $cont = 0; $vI = ''; $vF = '';
	mysql_select_db($database_horizonte, $horizonte);
	$consulta = "SELECT fr_sv as x, DATE_FORMAT(fecha_sv,'%d/%c/%Y') as fecha, peso_sv, DATE_FORMAT(fecha_sv,'%Y-%c-%d') as fecha1 from signos_vitales where id_paciente_sv = $idP and id_sv <= $idSV order by id_sv asc limit 50";
	$query = mysql_query($consulta) or die (mysql_error());
	while ($fila = mysql_fetch_array($query)) { $cont++;
		if($cont==1){$lista = $fila['x'];}else{$lista = $lista.','.$fila['x'];}
		if($cont==1){$lista1 = $fila['fecha'];}else{$lista1 = $lista1.','.$fila['fecha'];}
		
		$miF = $fila['fecha1'];
		mysql_select_db($database_horizonte, $horizonte); 
		$resultC = mysql_query("SELECT DATEDIFF('$miF',fNac_p) from pacientes where id_p = $idP ", $horizonte) or die (mysql_error());
		$rowC = mysql_fetch_row($resultC); $dias = $rowC[0];
		$edad = $dias/365; $peso = $fila['peso_sv'];
		
		if($edad==0){
			if( $peso < 2.5 ){$vMin = 40; $vMax = 60;}
			if( $peso >= 2.5 and $peso <= 4 ){$vMin = 40; $vMax = 60;}
			if( $peso >= 4 and $peso <= 6 ){$vMin = 30; $vMax = 50;}
		}
		if($edad==1){$vMin = 24; $vMax = 40;}
		if($edad==2){$vMin = 24; $vMax = 40;}
		if($edad==3){$vMin = 23; $vMax = 37;}
		if($edad==4){$vMin = 22; $vMax = 34;}
		if($edad==5){$vMin = 20; $vMax = 31;}
		if($edad>=6 and $edad<=13){$vMin = 18; $vMax = 28;}
		if($edad>13){$vMin = 12; $vMax = 16;}
		
		if($cont==1){$vI = $vMin;}else{$vI = $vI.','.$vMin;}
		if($cont==1){$vF = $vMax;}else{$vF = $vF.','.$vMax;}
		
	};
			
	echo $lista1.';*'.$lista.';*'.$cont.';*'.$vI.';*'.$vF;
 	//Cerrar conexión a la Base de Datos
 	mysql_close($horizonte);
?>