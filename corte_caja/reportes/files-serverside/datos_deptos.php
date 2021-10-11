<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $ref = sqlValue($_POST["ref"], "text");
 $sucu=  sqlValue($_POST["sucu"], "text");
 //$ref = sqlValue('20130321-5', "text");
 $salida = "";
 $totalSUCU = 0;
  
mysql_select_db($database_horizonte, $horizonte);
 $result = mysql_query("SELECT sum(pago_pag) from pagos_ov where referencia_pag = $ref ", $horizonte) or die (mysql_error());
 $row = mysql_fetch_row($result);
 $pagoTotalRef = $row[0];

 $result2 = mysql_query("SELECT p_tabulador_i_su, p_tabulador_l_su,p_tabulador_s_su, id_su from sucursales where clave_su = $sucu ", $horizonte) or die (mysql_error());
 $rowSu = mysql_fetch_row($result2);
 
 //tabuladores
 $t_imagen = $rowSu[0];  
 $t_lab = $rowSu[1];
 $t_ser = $rowSu[2];
 $id_su = $rowSu[3];

mysql_select_db($database_horizonte, $horizonte);
$result2 = mysql_query("SELECT c.concepto_to,v.contador_vc,v.precio_vc,v.precio_original,o.gran_total_ov,o.t_desc_cta, o.t_desc_img,o.t_desc_lab, o.t_desc_serv,t_desc_pro from orden_venta o left join venta_conceptos v on v.referencia_vc = o.referencia_ov left join conceptos c on c.id_to = v.id_concepto_es where o.referencia_ov = $ref order by v.contador_vc asc", $horizonte) or die (mysql_error());

while ( $rowX_1 = mysql_fetch_row($result2) ){ 
	$contX2++;	
	$totalCLI = $rowX_1[4];	//total de la venta registrada en BD
	$total_desc = $rowX_1[5]+$rowX_1[6]+$rowX_1[7]+$rowX_1[8]+$rowX_1[9]; //sacamos total de descuentos 
	$total_precio_vendido = $total_precio_vendido + $rowX_1[2]; //total del los precios de los productos vendidos
	$total_precio_original = $total_precio_original + $rowX_1[3]; // el total del precio original
	// $NUM = $totalCLI - $total_desc;
	$TOTAL_tod = round((($totalCLI*$t_lab)/100),2);
	//tabla
	$salida.=	"<tr>".
					"<th scope='row'><strong>".$rowX_1[1]."</strong></th>".
					"<td class='text-center'>".$rowX_1[0]."</td>".
					"<td class='text-center'>".$rowX_1[2]."</td>".
					"<td class='text-center'>".$rowX_1[3]."</td>".
					"<td></td>".
					"<td></td>".
					"<td></td>".
				"</tr>";
}

	$salida.=	"<tr class='bg-info'>".
					"<td>#</td>".
					"<td>TOTAL</td>".
					"<td class='bg-primary text-center'>".$total_precio_vendido."</td>".
					"<td class='bg-primary text-center'>".$total_precio_original."</td>".
					"<td class='bg-primary text-center'>$".$totalCLI." MXN</td>". 
					"<td class='bg-primary text-center'>$".$total_desc." MXN</td>".
					"<td class='bg-primary text-center'>$".$TOTAL_tod." MXN</td>".
				"</tr>"; 
	$datos = $salida."_;}{".$TOTAL_tod;
 	echo $datos;
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>
