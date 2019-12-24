<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idNh = sqlValue($_POST["idN"], "int"); $idH = sqlValue($_POST["idH"], "int");
 
 mysql_select_db($database_horizonte, $horizonte);
 $resultE = mysql_query("SELECT id_paciente_h from hospitalizacion where id_h = $idH ", $horizonte) or die (mysql_error());
 $rowE = mysql_fetch_row($resultE); $idP = sqlValue($rowE[0], "int");

 mysql_select_db($database_horizonte, $horizonte);
 $resultC = mysql_query("SELECT id_nota_nh, nota_nh, indicaciones_nh, recomendaciones_nh, id_sv_nh, usuario_nh, fecha_nh, aleatorio_nh from notas_de_hospital where id_nh = $idNh limit 1", $horizonte) or die (mysql_error());
 $rowC = mysql_fetch_row($resultC); $idCatNota = sqlValue($rowC[0], "int"); $idSV = sqlValue($rowC[4], "int");
 $idU = sqlValue($rowC[5], "int"); $aleatorio_n = sqlValue($rowC[7], "text");
 
 $lista = "<table width='100%' height='' align='left' border='0' cellspacing='0' cellpadding='3'>"; $i = 0;
	
 mysql_select_db($database_horizonte, $horizonte);
 $result0H = mysql_query("SELECT id_medicamento_mh, indicacion_mh, id_mh from medicamentos_hospital where aleatorio_mh = $aleatorio_n", $horizonte) or die (mysql_error()); 

 while ( $row0H = mysql_fetch_row($result0H) ){
	$i++;
	mysql_select_db($database_horizonte, $horizonte); 
	$resultEP = mysql_query("SELECT nombre_generico_med, cantidad_med, presentaciones_med, via_administracion_dosis_med from medicamentos where id_med = $row0H[0]", $horizonte) or die (mysql_error());
	$rowEP = mysql_fetch_row($resultEP);
	
	$nameC = $row0H[0].$i; $idC = $row0H[2].$i;
	$lista = $lista."<tr><td align='left'>$i.- <span style='text-decoration:underline;'>$rowEP[0]</span> $rowEP[1] $rowEP[2]</td></tr><tr><td><textarea onKeyUp='conMayusculas(this); nuevo(this.value, this.name);' name ='$nameC' class='miMedi' id='$nameC' lang = '$row0H[2]' cols='2' rows='2' style='resize:none; width:99%' readonly disabled>$row0H[1]</textarea></td></tr>";
 }
 
 mysql_select_db($database_horizonte, $horizonte);
 $resultME = mysql_query("SELECT count(id_mh) from medicamentos_hospital where aleatorio_mh = $aleatorio_n ", $horizonte) or die (mysql_error()); $rowME = mysql_fetch_row($resultME);
	
 mysql_select_db($database_horizonte, $horizonte);
 $result1 = mysql_query("SELECT fc_sv, fr_sv, concat(t_sv, '/', a_sv), temperatura_sv, peso_sv, talla_sv, imc_sv, cintura_sv, notas_sv, DATE_FORMAT(fecha_sv,'%d/%c/%Y %H:%i:%s') from signos_vitales where id_sv = $idSV ", $horizonte) or die (mysql_error());
 $row1 = mysql_fetch_row($result1);
		
 mysql_select_db($database_horizonte, $horizonte);
 $resultAl = mysql_query("SELECT alergia1_hc, alergia2_hc, alergia3_hc, alergia4_hc, alergia5_hc, alergia6_hc from historia_clinica where id_paciente_hc = $idP ", $horizonte) or die (mysql_error());
 $rowAl = mysql_fetch_row($resultAl);
	
 if($rowAl[0]=='' and $rowAl[1]=='' and $rowAl[2]=='' and $rowAl[3]=='' and $rowAl[4]=='' and $rowAl[5]==''){$alergias='NINGUNA';}
 else{
	if($rowAl[0]!=''){$aler = $rowAl[0];}
	if($rowAl[1]!=''){$aler = $aler.', '.$rowAl[1];}
	if($rowAl[2]!=''){$aler = $aler.', '.$rowAl[2];}
	if($rowAl[3]!=''){$aler = $aler.', '.$rowAl[3];}
	if($rowAl[4]!=''){$aler = $aler.', '.$rowAl[4];}
	if($rowAl[5]!=''){$aler = $aler.', '.$rowAl[5];}
	if($aler[0]==', '){$alergias = substr($aler, 1);}else{$alergias = $aler;}
 }
	
	mysql_select_db($database_horizonte, $horizonte); 
 	$resultU = mysql_query("SELECT nombre_u, apaterno_u, amaterno_u, sexo_u, cedulaProfesional_u, especialidad_u, cedulaProfesionalE_u, titulo_u, firma_u from usuarios where id_u = $idU limit 1", $horizonte) or die (mysql_error());
 	$rowU = mysql_fetch_row($resultU); $idEspecialidad = sqlValue($rowU[5], "int");
   
 mysql_select_db($database_horizonte, $horizonte); 
 $resultEsp = mysql_query("SELECT nombre_especialidad from especialidades where id_es = $idEspecialidad limit 1", $horizonte) or die (mysql_error());
 $rowEsp = mysql_fetch_row($resultEsp);
 
 if($rowEsp[0]!='' and $rowEsp[0]!='GENERAL'){ 
 	$doctorcito = $rowU[7].' '.$rowU[0]." ".$rowU[1]." ".$rowU[2]." <br>";
 	$especialidadDR = 'MÉDICO '.$rowEsp[0].' CÉDULA DE ESPECIALIDAD '.$rowU[6]; 
}else{
	$doctorcito = $rowU[7].' '.$rowU[0]." ".$rowU[1]." ".$rowU[2]." <span class='ocultoX1'><br>CÉDULA PROFESIONAL ".$rowU[4]."</span>";
	$especialidadDR = '';
}
	
	$datos = $rowC[1].';*}-{'.$alergias.';*}-{'.$row1[0].';*}-{'.$row1[1].';*}-{'.$row1[2].';*}-{'.$row1[3].';*}-{'.$row1[4].';*}-{'.$row1[5].';*}-{'.$row1[6].';*}-{'.$rowC[7].';*}-{'.$rowME[0].';*}-{'.$rowC[2].';*}-{'.$lista."</table>".';*}-{'.$rowC[3];
	
	echo $datos;
 	//Cerrar conexión a la Base de Datos
 	mysql_close($horizonte);
?>