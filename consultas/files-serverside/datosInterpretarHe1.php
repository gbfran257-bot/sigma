<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idP = sqlValue($_POST["idP"], "int");
 $idE = sqlValue($_POST["idE"], "int");

	mysql_select_db($database_horizonte, $horizonte);
	$result1 = mysql_query("SELECT v.referencia_vc, v.interpretacion_vc, v.nota_interpretacion, date_format(v.fecha_venta_vc,'%d/%c/%Y'), v.id_paciente_vc, v.id_personal_medico_vc, v.id_concepto_es, v.usuarioEdo5_e, v.contador_vc, c.id_area_to, v.nota_radiologo_vc, v.usuarioEdo5_e from venta_conceptos v left join conceptos c on c.id_to = v.id_concepto_es where v.id_vc = $idE ", $horizonte) or die (mysql_error());
 	$row1 = mysql_fetch_row($result1);
		
	$result2 = mysql_query("SELECT nombre_u, apaterno_u, amaterno_u from usuarios where id_u = $row1[5] ", $horizonte) or die (mysql_error());
 	$row2 = mysql_fetch_row($result2);
	
	$result3 = mysql_query("SELECT concepto_to from conceptos where id_to = $row1[6] ", $horizonte) or die (mysql_error());
 	$row3 = mysql_fetch_row($result3);
	
	$idUi = sqlValue($row1[11], "int");
	$result4 = mysql_query("SELECT nombre_u, apaterno_u, amaterno_u, cedulaProfesional_u, id_u, sexo_u, titulo_u from usuarios where id_u = $idUi ", $horizonte) or die (mysql_error());
 	$row4 = mysql_fetch_row($result4);
	
	$medicoEstudio = $row2[0]." ".$row2[1]." ".$row2[2];
	$medicoInterpreta = $row4[6]." ".$row4[0]." ".$row4[1]." ".$row4[2];
	if($row[9] != 55){
		$referenciaPacs = $row1[0];
	}else{$referenciaPacs = $row1[0]."-".$row1[8];}
	
	$referenciaPacs = substr($referenciaPacs, 2);
	$referenciaPacs = str_replace("-","",$referenciaPacs);
	
	$datos = $row1[0].';*-'.$row1[0].';*-'.$row1[0].';*-'.$row1[1].";*-".$row1[3].";*-".$row1[1].";*-".$row1[2].";*-".$medicoEstudio.";*-".$row3[0].";*-".$medicoInterpreta.";*-".$row4[3].";*-".$row1[7].".png".";*-".$referenciaPacs.";*-".$row1[10].";*-".$row1[4].";*-".$row4[5];
	
echo $datos;
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>