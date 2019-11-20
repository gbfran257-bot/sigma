<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	$idP = sqlValue($_POST["idP"], "int");
	$idSV = sqlValue($_POST["idSV"], "int");
		
	$lista = ''; $lista1 = ''; $cont = 0; $vI = ''; $vF = '';
	
	mysql_select_db($database_horizonte, $horizonte);
	$consulta = "SELECT talla_sv as x, DATE_FORMAT(fecha_sv,'%d/%c/%Y') as fecha, peso_sv, DATE_FORMAT(fecha_sv,'%Y-%c-%d') as fecha1 from signos_vitales where id_paciente_sv = $idP and id_sv <= $idSV order by id_sv asc limit 50";
	$query = mysql_query($consulta) or die (mysql_error());
	
	while ($fila = mysql_fetch_array($query)) { $cont++;
		if($cont==1){$lista = $fila['x'];}else{$lista = $lista.','.$fila['x'];}
		if($cont==1){$lista1 = $fila['fecha'];}else{$lista1 = $lista1.','.$fila['fecha'];}
		
		$miF = $fila['fecha1'];
		mysql_select_db($database_horizonte, $horizonte); 
		$resultC =mysql_query("SELECT DATEDIFF('$miF',fNac_p) from pacientes where id_p = $idP ", $horizonte) or die (mysql_error());
		$rowC = mysql_fetch_row($resultC); $dias = $rowC[0];
		$edad = $dias/365; $peso = $fila['peso_sv'];
		
		mysql_select_db($database_horizonte, $horizonte);
		$resultA = mysql_query("SELECT max(talla_sv) from signos_vitales where id_paciente_sv = $idP and id_sv <= $idSV ", $horizonte) or die (mysql_error());
		$rowA = mysql_fetch_row($resultA);
	
		$vMin = 0; $vMax = $rowA[0];
		
		if($cont==1){$vI = $vMin;}else{$vI = $vI.','.$vMin;}
		if($cont==1){$vF = $vMax;}else{$vF = $vF.','.$vMax;}
		
	};
				
	echo $lista1.';*'.$lista.';*'.$cont.';*'.$vI.';*'.$vF;
 	//Cerrar conexión a la Base de Datos
 	mysql_close($horizonte);
?>