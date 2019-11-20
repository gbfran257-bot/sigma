<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	$idP = sqlValue($_POST["idP"], "int");	
		
	$lista = ''; $lista1 = ''; $cont = 0;
	mysql_select_db($database_horizonte, $horizonte);
	$consulta = "SELECT imc_sv, DATE_FORMAT(fecha_sv,'%d/%c/%Y') as fecha from signos_vitales where id_paciente_sv = $idP group by DATE_FORMAT(fecha_sv,'%d/%c/%Y')";
	$query = mysql_query($consulta) or die (mysql_error());
	while ($fila = mysql_fetch_array($query)) { $cont++;
		if($cont==1){$lista = $fila['imc_sv'];}else{$lista = $lista.','.$fila['imc_sv'];}
		if($cont==1){$lista1 = $fila['fecha'];}else{$lista1 = $lista1.','.$fila['fecha'];}
	};//echo $lista;
			
	echo $lista1.';*'.$lista.';*'.$cont;
 	//Cerrar conexión a la Base de Datos
 	mysql_close($horizonte);
?>