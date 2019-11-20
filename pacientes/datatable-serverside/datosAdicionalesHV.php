<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");
//Generales
 $ref = sqlValue($_POST['ref'], "text");//nombre de usuario del usuario

mysql_select_db($database_horizonte, $horizonte);
$result = mysql_query("
	SELECT vc.contador_vc, tc.tipo_concepto_tc, c.concepto_to, tc.tipo_concepto_tc, concat(vc.referencia_vc,'/',contador_vc), 
		vc.estatus_vc, vc.precio_vc,id_personal_medico_vc, e.estatus_est, cv.convenio_cv, c.id_departamento_to, vc.id_vc, vc.referencia_vc from venta_conceptos vc
		left join estatus e on e.id_est = vc.estatus_vc 
		left join conceptos c on c.id_to = vc.id_concepto_es 
		left join catalogo_tipo_conceptos tc on tc.id_tc = c.id_tipo_concepto_to 
		left join convenios cv on cv.id_cv = vc.id_convenio_vc
		where vc.referencia_vc = $ref 
	", $horizonte) or die (mysql_error()); 

echo "<table class='table-condensed table-bordered' width='100%' height='100%'> \n"; 
echo "<tr class='bg-info'>
		<td>#</td>
		<td>CONCEPTO</td>
		<td>DESCRIPCI&Oacute;N</td>
		<td>REFERENCIA</td>
		<td>ESTATUS</td>
		<td>PRECIO</td>
		<td>BENEFICIO</td>
		<td class='hidden'>CANCELAR</td>
	</tr> \n";
$cont = 0;
while ( $row = mysql_fetch_row($result) ){ 
	if($row[9]==''){$row[9]='PARTICULAR';}
	if($row[1]=='CARGO ADICIONAL' or $row[2]=='IVA'){
		$row[8] = '-';
		$row[9]='-';
		if($row[6]==0.00){continue;}
	}$cont++;
	if($row[8]!='PENDIENTE'){$algo = "<td class='hidden' align='center'>-</td>";}
	else{
		//$algo = "<td align='center'><span lang='$row[2]' id='$row[12]' style='text-decoration:underline; cursor:pointer' onClick='CancelItem($row[11],this.id,this.lang)'>Cancelar</span></td>";
		$algo = "<td align='center' class='hidden'><span lang='$row[2]' id='$row[12]' style='text-decoration:underline; cursor:pointer' onClick='CancelItem($row[11],this.id,this.lang)'>Cancelar</span></td>";
	}
	
	echo"<tr style='color:black;' class='$row[11]'>
			<td>$cont</td>
			<td>$row[1]</td>
			<td>$row[2]</td>
			<td nowrap>$row[4]</td>
			<td>$row[8]</td>
			<td style='text-align:right'>$$row[6]</td>
			<td>$row[9]</td>".$algo."
		</tr> \n"; 
} 
echo "</table> \n"; 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>