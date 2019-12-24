<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $aleatorio = sqlValue($_POST["aleatorio"], "text");
 mysql_select_db($database_horizonte, $horizonte); 
 $result = mysql_query("SELECT e.concepto_to, v.precio_vc, count(e.id_to) from venta_conceptos v left join conceptos e on e.id_to = v.id_concepto_es where v.no_temp_vc = $aleatorio and e.id_tipo_concepto_to = 5 group by e.id_to", $horizonte) or die (mysql_error());
 $cont = 0; echo "<table class='table-condensed'> \n"; 
while ( $row = mysql_fetch_row($result) ){ 
	$cont++;
	echo"<tr style='color:black;' class='$row[11]'>
			<td>$cont</td>
			<td>$row[0]</td>
			<td>x $row[2]</td>
		</tr> \n"; 
} 
echo "</table> \n"; 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>