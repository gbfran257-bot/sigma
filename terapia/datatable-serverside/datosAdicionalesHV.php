<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");
//Generales
 $ref = sqlValue($_POST['ref'], "text");//nombre de usuario del usuario

mysql_select_db($database_horizonte, $horizonte);
$result = mysql_query("
	SELECT vc.contador_vc, tc.tipo_concepto_tc, c.concepto_to, vc.tipo_concepto_vc, concat(vc.referencia_vc,'/',contador_vc), 
		vc.estatus_vc, vc.precio_normal_vc,id_personal_medico_vc, e.estatus_est, cv.convenio_cv, vc.departamento_vc from venta_conceptos vc
		left join estatus e on e.id_est = vc.estatus_vc 
		left join catalogo_tipo_conceptos tc on tc.id_tc = vc.tipo_concepto_vc 
		left join conceptos c on c.id_to = vc.id_concepto_es 
		left join convenios cv on cv.id_cv = vc.id_convenio_vc
		where vc.referencia_vc = $ref 
	", $horizonte) or die (mysql_error()); 

echo "<table border = '1' cellpadding='1' cellspacing='0' width='100%' height='100%' style='background-color:gray; font-size:1em;'> \n"; 
echo "<tr style='text-decoration:;font-style:italic; color:red;'>
		<td>#</td>
		<td>CONCEPTO</td>
		<td>DESCRIPCI&Oacute;N</td>
		<td>REFERENCIA</td>
		<td>ESTATUS</td>
		<td>PRECIO</td>
		<td>BENEFICIO</td>
	</tr> \n";
$cont = 0;
while ( $row = mysql_fetch_row($result) ){ 
	if($row[9]==''){$row[9]='PARTICULAR';}
	if($row[1]=='CARGO ADICIONAL' or $row[2]=='IVA'){
		$row[8] = '-';
		$row[9]='-';
		if($row[6]==0.00){continue;}
	}$cont++;
	echo"<tr style='color:blue;'>
			<td>$cont</td>
			<td>$row[1]</td>
			<td>$row[2]</td>
			<td nowrap>$row[4]</td>
			<td>$row[8]</td>
			<td style='text-align:right'>$$row[6]</td>
			<td>$row[9]</td>
		</tr> \n"; 
} 
echo "</table> \n"; 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>