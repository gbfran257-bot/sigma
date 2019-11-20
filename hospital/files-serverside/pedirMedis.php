<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	$idH = sqlValue($_POST["idH"], "int");
	$aleatorio = sqlValue($_POST["aleatorio"], "text");
	$lista = "<table width='100%' height='' align='left' border='0' cellspacing='0' cellpadding='3'>"; $i = 0;
	
	mysql_select_db($database_horizonte, $horizonte);
	$result = mysql_query("SELECT id_medicamento_mh, indicacion_mh, id_mh from medicamentos_hospital where id_hospitalizacion_mh = $idH and aleatorio_mh = $aleatorio", $horizonte) or die (mysql_error()); 
	
	while ( $row = mysql_fetch_row($result) ){
		$i++;
		mysql_select_db($database_horizonte, $horizonte); 
 		$resultEP = mysql_query("SELECT nombre_generico_med, cantidad_med, presentaciones_med, via_administracion_dosis_med from medicamentos where id_med = $row[0]", $horizonte) or die (mysql_error());
 		$rowEP = mysql_fetch_row($resultEP);
		
		$nameC = $row[0].$i; $idC = $row[2].$i;
		$lista = $lista."<tr><td align='left'>$i.- <span style='text-decoration:underline;'>$rowEP[0]</span> $rowEP[1] $rowEP[2]</td></tr><tr><td><textarea onKeyUp='conMayusculas(this); nuevo(this.value, this.name);' name ='$nameC' class='miMedi' id='$nameC' lang = '$row[2]' cols='2' rows='2' style='resize:none; width:99%'>$row[1]</textarea></td></tr>";

	} 
	
	echo $lista."</table>";
 	//Cerrar conexión a la Base de Datos
 	mysql_close($horizonte);
?>