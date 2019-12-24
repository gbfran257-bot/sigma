<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	$idC = sqlValue($_POST["idC"], "int"); $lista = "<table width='100%'>"; $i = 0;
	
	mysql_select_db($database_horizonte, $horizonte);
	$result = mysql_query("SELECT m.id_med_mr, m.id_med_mr, m.id_med_mr from medicamentos_receta m left join conceptos c on c.id_to = m.id_med_mr where m.id_co_mr = $idC and c.id_area_to = 61 and c.id_departamento_to = 3 and c.id_tipo_concepto_to = 5", $horizonte) or die (mysql_error()); 
	while ( $row = mysql_fetch_row($result) ){
		$i++;
		mysql_select_db($database_horizonte, $horizonte); 
 		$resultEP = mysql_query("SELECT c.concepto_to, m.nombre_generico_med, m.cantidad_med, m.descripcion_med, c.descripcion_to from medicamentos m left join conceptos c on c.id_medicamento_g = m.id_med where c.id_to = $row[0]", $horizonte) or die (mysql_error());
 		$rowEP = mysql_fetch_row($resultEP);
		
		$nameC = $row[0].$i; //$idC = $row[2].$i;
		$lista = $lista.'<tr><td align="left" style="font-size:10pt;">'.$i.'.- <span style="text-decoration:underline;">'.ucfirst(strtolower($rowEP[0])).'</span> ('.ucfirst(strtolower($rowEP[1])).') '.ucfirst(strtolower($rowEP[2])).' '.ucfirst(strtolower($rowEP[3])).'</td></tr>';
		$lista = $lista.'<tr><td align="left" style="font-size:10pt;">&nbsp;&nbsp;'.ucfirst(strtolower($rowEP[4])).' </td></tr>';
	} 
	$lista = $lista.'</table><br>';

 mysql_select_db($database_horizonte, $horizonte); 
 $resultC = mysql_query("SELECT count(id_mr) from medicamentos_receta where id_co_mr = $idC", $horizonte) or die (mysql_error());
 $rowC = mysql_fetch_row($resultC);
 
 echo $rowC[0].';}{;'.$lista;

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>