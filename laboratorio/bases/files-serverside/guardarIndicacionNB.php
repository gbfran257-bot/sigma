<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $noTemp = sqlValue($_POST["noAleatorio"], "text");
 $indicacion = sqlValue($_POST["indicacion"], "int");
 $idU = sqlValue($_POST["idU"], "int");

 mysql_select_db($database_horizonte, $horizonte); 
 $resultC = mysql_query("SELECT id_in, indicacion_in from indicaciones where id_in = $indicacion ", $horizonte) or die (mysql_error());
 $rowC = mysql_fetch_row($resultC);
 
 mysql_select_db($database_horizonte, $horizonte); 
 $resultC1 = mysql_query("SELECT count(id_ai) from asignar_indicacion where id_indicacion_ai = $indicacion and aleatorio_ai = $noTemp", $horizonte) or die (mysql_error());
 $rowC1 = mysql_fetch_row($resultC1);
	 
 $idI = sqlValue($rowC[0], "int");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
	
 if($rowC1[0]<1){
	 mysql_select_db($database_horizonte, $horizonte); 
	 $sql="INSERT INTO asignar_indicacion(aleatorio_ai,id_indicacion_ai,usuario_reg_ai,fecha_reg_ai)";
	 $sql.= "VALUES ($noTemp, $idI, $idU, $now)"; 
	 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	 if (!$update) { echo $sql; }else{  echo 1; }
 }else{echo 1;}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>