<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");
//Generales
 $ref = sqlValue($_POST["ref"], "text");
 //$ref = "'"."20130320-3"."'";
  
 mysql_select_db($database_horizonte, $horizonte);
 $resultR = mysql_query("SELECT departamento_vc from venta_conceptos where referencia_vc = $ref and tipo_concepto_vc = 3 ", $horizonte) or die (mysql_error());
 $row_R = mysql_fetch_assoc($resultR);
 $totalRows_R = mysql_num_rows($resultR);
   
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>

 <?php
 $j=0;
 $p = array();
 $por='';
do {  
      $puteria[$j] = $row_R['departamento_vc'];

	  $j++;
} while ($row_R = mysql_fetch_assoc($resultR));
$i=0;
for($i=0;$i<$j;$i++){
	$por=$por.$puteria[$i].";";
}
echo $por;

?>