<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $noTemp = sqlValue($_POST["noAleatorio"], "text");

 mysql_select_db($database_horizonte, $horizonte); 
 $resultC = mysql_query("SELECT nota_interpretacion from venta_conceptos where no_temp_vc = $noTemp", $horizonte) or die (mysql_error());
 $rowC = mysql_fetch_row($resultC);
 
 if($rowC[0]!=''){echo 1;}else{echo 0;}
 
 //echo $rowC[0];

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>