<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $aleatorio = sqlValue($_POST["aleatorio"], "text");
 mysql_select_db($database_horizonte, $horizonte);
 $result = mysql_query("SELECT e.concepto_to, v.precio_vc, v.descuento, v.motivo_alteracion from venta_conceptos v left join conceptos e on e.id_to = v.id_concepto_es where v.no_temp_vc = $aleatorio and e.id_tipo_concepto_to = 1", $horizonte) or die (mysql_error());
 $cont = 0; echo "<table class='table-condensed' style='width:100%;'> \n";
 while ( $row = mysql_fetch_row($result) ){
	$cont++;
	if($row[2]>0){
		$concepto = "DESCUENTO($row[3])";
		$monto = "-$" . $row[2];
	}
	else{
		$concepto = "";
		$monto = "";
	}
	/* echo"<tr style='color:black;' class='$row[11]'>
			<td>$cont</td>
			<td>$row[0]</td>
		</tr> \n"; */
		echo"<tr style='color:black;' class='$row[11]'>
		<td style='float: left;'>$cont</td>
		<td style='float: left;'>$row[0] <p style='color:red;'>$concepto</p></td>
		<td style='float: right;'><p style='color:red;'>$monto</p></td>
	</tr> \n"; 
 } 
 echo "</table> \n";
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>