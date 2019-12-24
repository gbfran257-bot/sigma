<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idH = sqlValue($_POST["idH"], "int");
 $idP = sqlValue($_POST["idP"], "int");
 $idU = sqlValue($_POST["idU"], "int");
 $idMED = sqlValue($_POST["claveMED"], "int");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 $aleatorio = sqlValue($_POST["aleatorio"], "text");
	
	mysql_select_db($database_horizonte, $horizonte); 
	$resultI = mysql_query("SELECT via_administracion_dosis_med from medicamentos where id_med = $idMED limit 1 ", $horizonte) or die (mysql_error());
	$rowI = mysql_fetch_row($resultI); $indi = sqlValue($rowI[0], "text");
	
 mysql_select_db($database_horizonte, $horizonte); 

$sql="INSERT INTO medicamentos_hospital(id_hospitalizacion_mh,id_u_mh,id_medicamento_mh,fecha_mh,aleatorio_mh) VALUES($idH,$idU, $idMED, $now,$aleatorio)";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) { echo $sql; }else{  echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>