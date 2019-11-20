<?php
require("../../../../Connections/horizonte.php");
require("../../../../funciones/php/values.php");
//Generales
 $aData = sqlValue($_POST['ref'], "text");//nombre de usuario del usuario

mysql_select_db($database_horizonte, $horizonte);
$result = mysql_query("SELECT u.usuario_u, e.concepto_to, vc.id_concepto_es, d.nombre_d, a.nombre_a, vc.precio_normal_vc, u.amaterno_u, vc.tipo_concepto_vc from venta_conceptos vc left join usuarios u on u.id_u = vc.id_usuario_vc left join conceptos e on e.id_to = vc.id_concepto_es left join departamentos d on d.id_d = vc.departamento_vc left join areas a on a.id_a = vc.area_vc where vc.referencia_vc = $aData ", $horizonte) or die (mysql_error()); 
$result1 = mysql_query("SELECT concat(u.nombre_u,' ', u.apaterno_u), u.amaterno_u from venta_conceptos vc left join usuarios u on u.id_u = vc.id_personal_medico_vc where vc.referencia_vc = $aData ", $horizonte) or die (mysql_error()); 

echo "<table border = '1' cellpadding='1' cellspacing='0' width='100%' style='background-color:white; font-size:1.3em;' class='tablilla'> \n"; 
echo "<tr style='text-decoration:; color:white;' bgcolor='#FF6633;'>
		<td style='font-weight:bold; font-style:italic'>DESCRIPCI&Oacute;N</td>
		<td style='font-weight:bold; font-style:italic'>PERSONAL M&Eacute;DICO</td>
		<td style='font-weight:bold; font-style:italic'>DEPARTAMENTO</td>
		<td style='font-weight:bold; font-style:italic'>&Aacute;REA</td>
		<td style='font-weight:bold; font-style:italic; text-align:center'>TOTAL</td>
	</tr> \n"; 
while ($row = mysql_fetch_row($result) and $row1 = mysql_fetch_row($result1)){ 
		if($row[7]==6 || $row[7]==7){ $row[4] = '-'; if($row[5]==0){continue;} }else{ }
		if($row1[0]==''){$row1[0]='-';}
       echo "<tr>
			<td>$row[1]</td>
			<td>$row1[0] $row1[1]</td>
			<td>$row[3]</td>
			<td>$row[4]</td>
			<td style='text-align:right'>$$row[5]</td>
	   </tr> \n"; 
} 
echo "</table> \n"; 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>