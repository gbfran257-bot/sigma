<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	$idC = sqlValue($_POST["idC"], "int"); $lista = "<table width='100%'>"; $i = 0;
	
	mysql_select_db($database_horizonte, $horizonte);
	$result = mysql_query("SELECT id_dx_dxc, nota_medica_dxc, id_dxc, primario_dxc from dx_consultas where id_c_dxc = $idC order by primario_dxc desc", $horizonte) or die (mysql_error()); 
	
	while ( $row = mysql_fetch_array($result) ){ $i++;
		mysql_select_db($database_horizonte, $horizonte); $id_di = $row['id_dx_dxc'];
 		$resultEP = mysql_query("SELECT nombre_di from diagnosticos where id_di = $id_di", $horizonte) or die (mysql_error());
 		$rowEP = mysql_fetch_row($resultEP);
		
		$nameC = $row['id_dx_dxc'].$i; //$idC = $row[2].$i;
		$lista = $lista."<tr><td align='left' style='font-size:10pt;'>$i.- <span style='text-decoration:underline;'>".ucfirst($rowEP[0])."</span></td></tr>";
	}

	$lista = $lista."</table>";
	
 mysql_select_db($database_horizonte, $horizonte); 
 $resultC = mysql_query("SELECT count(id_dxc) from dx_consultas where id_c_dxc = $idC", $horizonte) or die (mysql_error());
 $rowC = mysql_fetch_row($resultC);
 
 echo $rowC[0].';}{;'.$lista;

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>