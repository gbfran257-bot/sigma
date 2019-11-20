<?php
require("../../../Connections/sigma.php");
require("../../../funciones/php/values.php");
//Generales
 $ref = sqlValue($_POST["ref"], "text");
 $ref = "'"."20130319-2"."'";
  
 mysql_select_db($database_sigma, $sigma);
 $resultR = mysql_query("SELECT departamento_vc from venta_conceptos where referencia_vc = $ref and tipo_concepto_vc = 2 ", $sigma) or die (mysql_error());
 $row_R = mysql_fetch_assoc($resultR);
 $totalRows_R = mysql_num_rows($resultR);
  
 //$subtotales = $rowR[0];
 
 //echo $total;

 $j=0;
 $p = array();
 $por="";
do {  
      $puteria[$j] = $row_R['departamento_vc'];
	  //$p[$j]=$puteria[$j]*100/$total;
	  //echo $p[$j];
	  //echo "</br>";
	  $j++;
} while ($row_R = mysql_fetch_assoc($resultR));
$i=0;
for($i=0;$i<$j;$i++){
	$por=$por.$puteria[$i].";";
}
echo $por;

//Cerrar conexión a la Base de Datos
 mysql_close($sigma);
?>