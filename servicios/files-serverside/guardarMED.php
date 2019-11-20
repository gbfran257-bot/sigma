<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $noTemp = sqlValue($_POST["noAleatorio"], "text");
 $idP = sqlValue($_POST["idP"], "int");
 $idU = sqlValue($_POST["idU"], "int");
 $idC = sqlValue($_POST["idC"], "int");
 $idMED = sqlValue($_POST["claveMED"], "int");

 $now = sqlValue(date('Y-m-d H:i:s'), "date");
	
mysql_select_db($database_horizonte, $horizonte); 
$resultI = mysql_query("SELECT via_administracion_dosis_med from medicamentos where id_med = $idMED limit 1 ", $horizonte) or die (mysql_error());
$rowI = mysql_fetch_row($resultI);

$indi = sqlValue($rowI[0], "text");
	
 mysql_select_db($database_horizonte, $horizonte); 

$sql="INSERT INTO medicamentos_receta(no_temp_mr,id_p_mr,id_u_mr,id_med_mr,fecha_mr, id_co_mr) VALUES ($noTemp, $idP, $idU, $idMED, $now, $idC)";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) { echo $sql; }else{  echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>