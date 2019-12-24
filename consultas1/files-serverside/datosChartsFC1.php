<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	$idP = sqlValue($_POST["idP"], "int");
	$idSV = sqlValue($_POST["idSV"], "int");
		
	$lista = ''; $lista1 = ''; $cont = 0; $vI = ''; $vF = '';
	mysql_select_db($database_horizonte, $horizonte);
	$consulta = "SELECT fc_sv as x, DATE_FORMAT(fecha_sv,'%d/%c/%Y') as fecha, peso_sv, DATE_FORMAT(fecha_sv,'%Y-%c-%d') as fecha1 from signos_vitales where id_paciente_sv = $idP and id_sv <= $idSV order by id_sv asc limit 50";
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
			if( $peso < 2.5 ){$vMin = 140; $vMax = 160;}
			if( $peso >= 2.5 and $peso <= 4 ){$vMin = 140; $vMax = 160;}
			if( $peso >= 4 and $peso <= 6 ){$vMin = 120; $vMax = 160;}
		}
		if($edad==1){$vMin = 100; $vMax = 140;}
		if($edad==2){$vMin = 90; $vMax = 140;}
		if($edad==3){$vMin = 85; $vMax = 125;}
		if($edad==4){$vMin = 80; $vMax = 110;}
		if($edad==5){$vMin = 78; $vMax = 105;}
		if($edad>=6 and $edad<=13){$vMin = 75; $vMax = 100;}
		if($edad>13){$vMin = 60; $vMax = 90;}
		
		if($cont==1){$vI = $vMin;}else{$vI = $vI.','.$vMin;}
		if($cont==1){$vF = $vMax;}else{$vF = $vF.','.$vMax;}
		
	};
			
	echo $lista1.';*'.$lista.';*'.$cont.';*'.$vI.';*'.$vF;
 	//Cerrar conexión a la Base de Datos
 	mysql_close($horizonte);
?>