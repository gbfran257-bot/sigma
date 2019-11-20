<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $noTemp = sqlValue($_POST["noAleatorio"], "text");
 $tipoItem = sqlValue($_POST["tipoItem"], "int");
 $departamento = sqlValue($_POST["departamento"], "int");
 
 mysql_select_db($database_horizonte, $horizonte); 
 if($_POST["departamento"]==0){
	 $resultC = mysql_query("SELECT count(id_vc) from venta_conceptos where no_temp_vc = $noTemp and tipo_concepto_vc =  $tipoItem", $horizonte) or die (mysql_error());
 }else{
	 $resultC = mysql_query("SELECT count(id_vc) from venta_conceptos where no_temp_vc = $noTemp and tipo_concepto_vc =  $tipoItem and departamento_vc = $departamento", $horizonte) or die (mysql_error());
 }
 $rowC = mysql_fetch_row($resultC);
		
echo $rowC[0];

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>