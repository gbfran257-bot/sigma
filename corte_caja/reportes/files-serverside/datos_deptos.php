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

 $result2 = mysql_query("SELECT p_tabulador_i_su, p_tabulador_l_su,p_tabulador_s_su from sucursales where clave_su = $sucu ", $horizonte) or die (mysql_error());
 $rowSu = mysql_fetch_row($result2);
 
 //tabuladores
 $t_imagen = $rowSu[0];  
 $t_lab = $rowSu[1];
 $t_ser = $rowSu[2];


 // $resultTlb = mysql_query("SELECT p.pago_pag, ps.id_ov FROM pagos_ov p JOIN orden_venta ov on p.referencia_pag = ov.referencia_ov JOIN pagos_sucursal ps on ps.id_ov = ov.id_ov  WHERE P.departamento_pa = 1 AND p.referencia_pag = $ref ", $horizonte) or die (mysql_error());
 //    $totalTL= 0;
 //    $conTL = 0;
 //    while ($fila = mysql_fetch_assoc($resultTlb)) {
 //        $totalTL = $totalTL + intval($fila["pago_pag"]);
 //        if($fila["id_ov"] != null){
 //            $conTL++;
 //        }
 //    }
	

 mysql_select_db($database_horizonte, $horizonte);
$result1 = mysql_query("SELECT c.concepto_to, v.contador_vc, c.id_departamento_to,c.precio_to from orden_venta o left join venta_conceptos v on v.referencia_vc = o.referencia_ov left join conceptos c on c.id_to = v.id_concepto_es where o.referencia_ov = $ref order by v.contador_vc asc", $horizonte) or die (mysql_error());
$totalLAB = 0;
$totalIMG = 0;
$totalFARM = 0;
$totalSER = 0;
while ( $rowX = mysql_fetch_row($result1) ){ 
	$contX++;
	$totalTL0=(($rowX[3]*$t_lab)/100);  // precio del estudio de LABORATORIO que debe pagar la sucursal
	$totalTI0=(($rowX[3]*$t_imagen)/100);  // precio del estudio de IMAGEN que debe pagar la sucursal
	$totalTF0=intval($rowX[3]); // precio del MEDICAMENTO de FARMACIA que debe pagar la sucursal
	$totalTS0=(($rowX[3]*$t_ser)/100); // precio del SERVICIO  que debe pagar la sucursal


	
	$salida.=	"<tr>".

					"<th scope='row'><strong>".$rowX[1]."</strong></th>".
					"<td>".$rowX[0]."</td>";

//mostrar precios de laboratorio
	if($rowX[2] != 1){
		$salida .=	"<td>0</td>";
	}else{
		$salida .=	"<td>".$totalTL0."</td>";
		$totalLAB = $totalLAB + $totalTL0;
	}
//mostrar precios de imagen
	if($rowX[2] != 2){
		$salida .=	"<td>0</td>";
	}else{
		$salida .=	"<td>".$totalTI0."</td>";
		$totalIMG = $totalIMG + $totalTI0;
	}
//mostrar precios de farmacia
	if($rowX[2] != 3){
		$salida .=	"<td>0</td>";
	}else{
		$salida .=	"<td>".$totalTF0."</td>";
		$totalFARM = $totalFARM + $totalTF0;
	}
//mostrar precios de SERVICIOS
	if($rowX[2] != 4){
		$salida .=	"<td>0</td>";
	}else{
		$salida .=	"<td>".$totalTS0."</td>";
		$totalSER = $totalSER + $totalTS0;
	}
	$salida .=		"<td>".$rowX[3]."</td>".
		$totalCLI = $totalCLI + $rowX[3];
				"</tr>";	

}
 $salida.="	<tr class='bg-info'>
 				<td>#</td>
 				<td>TOTAL</td>
 				<td class='bg-primary'>".$totalLAB."</td>
 				<td class='bg-primary'>".$totalIMG."</td>
 				<td class='bg-primary'>".$totalFARM."</td>
 				<td class='bg-primary'>".$totalSER."</td>
 				<td class='bg-primary'>".$totalCLI."</td>
 			</tr>
 		</tbody>";
 $TOTAL_tod = $totalLAB+$totalIMG+$totalFARM+$totalSER;



$datos = $salida ."_;}{".$TOTAL_tod;
 echo $datos;
//  $old_saldo = $row[1]-$old_abonado;
//  $new_abonado = $old_abonado;
//  $new_saldo = $old_saldo;
//   //echo $new_abonado;

// $sql="UPDATE orden_venta SET abonado_ov = $new_abonado, saldo_ov = $new_saldo where referencia_ov = ".$ref.";";
	
// $insertar2 = mysql_query($sql, $horizonte) or die (mysql_error());
// if (!$insertar2) {echo $sql;}
// else{echo "ok";}
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>