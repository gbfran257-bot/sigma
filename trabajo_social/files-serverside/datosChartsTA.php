<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	$idP = sqlValue($_POST["idP"], "int");	
		
	$lista = ''; $lista1 = ''; $cont = 0; $vI = ''; $vF = '';
	mysql_select_db($database_horizonte, $horizonte);
	$consulta = "SELECT TRUNCATE( (t_sv/a_sv), 2) as x, DATE_FORMAT(fecha_sv,'%d/%c/%Y') as fecha, peso_sv, DATE_FORMAT(fecha_sv,'%Y-%c-%d') as fecha1 from signos_vitales where id_paciente_sv = $idP order by id_sv asc limit 100";
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
			if( $peso < 2.5 ){$vMin = 2.44; $vMax = 1.64;}
			if( $peso >= 2.5 and $peso <= 4 ){$vMin = 2.00; $vMax = 1.56;}
			if( $peso >= 4 and $peso <= 6 ){$vMin = 1.48; $vMax = 1.43;}
		}
		if($edad==1){$vMin = 1.48; $vMax = 1.43;}
		if($edad==2){$vMin = 1.60; $vMax = 1.40;}
		if($edad==3){$vMin = 1.62; $vMax = 1.40;}
		if($edad==4){$vMin = 1.64; $vMax = 1.40;}
		if($edad==5){$vMin = 1.54; $vMax = 1.45;}
		if($edad>=6 and $edad<=13){$vMin = 1.56; $vMax = 1.50;}
		if($edad>13){$vMin = 1.52; $vMax = 1.59;}
		
		if($cont==1){$vI = $vMin;}else{$vI = $vI.','.$vMin;}
		if($cont==1){$vF = $vMax;}else{$vF = $vF.','.$vMax;}
		
	};
			
	echo $lista1.';*'.$lista.';*'.$cont.';*'.$vI.';*'.$vF;
 	//Cerrar conexión a la Base de Datos
 	mysql_close($horizonte);
?>