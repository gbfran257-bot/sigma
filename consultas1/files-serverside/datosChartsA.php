<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	$idP = sqlValue($_POST["idP"], "int");
	$idSV = sqlValue($_POST["idSV"], "int");
		
	$lista = ''; $lista1 = ''; $cont = 0;
	
	mysql_select_db($database_horizonte, $horizonte);
	$consulta = "SELECT imc_sv, DATE_FORMAT(fecha_sv,'%d/%c/%Y') as fecha from signos_vitales where id_paciente_sv = $idP and id_sv <= $idSV group by DATE_FORMAT(fecha_sv,'%d/%c/%Y') order by id_sv asc limit 50";
	$query = mysql_query($consulta) or die (mysql_error());
	while ($fila = mysql_fetch_array($query)) { $cont++;
		if($cont==1){$lista = $fila['imc_sv'];}else{$lista = $lista.','.$fila['imc_sv'];}
		if($cont==1){$lista1 = $fila['fecha'];}else{$lista1 = $lista1.','.$fila['fecha'];}
	};//echo $lista;
	
	mysql_select_db($database_horizonte, $horizonte);
	$resultA = mysql_query("SELECT nombre_p, apaterno_p, amaterno_p from pacientes where id_p = $idP ", $horizonte) or die (mysql_error());
 	$rowA = mysql_fetch_row($resultA); $nombreP = $rowA[0].' '.$rowA[1].' '.$rowA[2];
			
	echo $lista1.';*'.$lista.';*'.$cont.';*'.$nombreP;
 	//Cerrar conexión a la Base de Datos
 	mysql_close($horizonte);
?>