<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");
//Generales
 $aData = sqlValue($_POST['ref'], "text");//nombre de usuario del usuario
$aData = explode("<br>", $aData);
$aData = str_replace('"', '', $aData[0]);
mysql_select_db($database_horizonte, $horizonte);
$result = mysql_query("SELECT u.usuario_u, e.concepto_to, vc.id_concepto_es, d.nombre_d, a.nombre_a, vc.precio_vc, u.amaterno_u, t.tipo_concepto_tc, cv.convenio_cv, o.adicionales_c_ov+o.adicionales_ei_ov+o.adicionales_el_ov+o.adicionales_s_ov as adicionales, o.t_desc_cta+o.t_desc_img+o.t_desc_lab+o.t_desc_serv as descuentos, o.iva_ov, concat(u1.nombre_u,' ', u1.apaterno_u), u1.amaterno_u from venta_conceptos vc left join usuarios u on u.id_u = vc.id_usuario_vc left join conceptos e on e.id_to = vc.id_concepto_es left join departamentos d on d.id_d = e.id_departamento_to left join areas a on a.id_a = e.id_area_to left join convenios cv on cv.id_cv = vc.id_convenio_vc left join catalogo_tipo_conceptos t on t.id_tc = e.id_tipo_concepto_to left join orden_venta o on o.referencia_ov = vc.referencia_vc left join usuarios u1 on u1.id_u = vc.id_personal_medico_vc where vc.referencia_vc = $aData ", $horizonte) or die (mysql_error());
		
echo "<table id='tabliT' width='100%' class='table-condensed table-bordered table-striped small'> \n"; 
echo "<tr style='text-align:center;' height='10px' class=''>
		<td>DESCRIPCI&Oacute;N</td>
		<td>PERSONAL M&Eacute;DICO</td>
		<td>DEPARTAMENTO</td>
		<td>&Aacute;REA</td>
		<td>BENEFICIO</td>
		<td>TOTAL</td>
	  </tr> \n"; 
while ($row = mysql_fetch_row($result)){
		if($row[7]==6 || $row[7]==7){ $row[4] = '-'; $row[8]='-'; if($row[5]==0){continue;} }else{ }
		if($row1[0]==''){$row1[0]='-';}
		if($row[8]==''){$row[8]='PARTICULAR';}
       echo "<tr>
	   	<td>$row[1]</td>
		<td>$row[12] $row[13]</td>
		<td>$row[3]</td>
		<td>$row[4]</td>
		<td>$row[8]</td>
		<td style='text-align:right'>$ $row[5]</td>
	   </tr> \n"; 
}
$rowa = mysql_fetch_row($result);
if($rowa[9]>0){
	echo "<tr>
	   	<td>CARGOS ADICIONALES</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td style='text-align:right'>$ $rowa[9]</td>
	   </tr> \n"; 
}
if($rowa[10]>0){
	echo "<tr>
	   	<td>DESCUENTO</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td style='text-align:right'>$ $rowa[10]</td>
	   </tr> \n"; 
}
if($rowa[11]>0){
	echo "<tr>
	   	<td>IVA</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td style='text-align:right'>$ $rowa[11]</td>
	   </tr> \n"; 
}
echo "</table> \n"; 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>