<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $noTemp = sqlValue($_POST["noAleatorio"], "text");
 $base = sqlValue($_POST["base"], "int");
 $idU = sqlValue($_POST["idU"], "int");
 $idE = sqlValue($_POST["idE"], "int");

	 mysql_select_db($database_horizonte, $horizonte); 
	 $resultC = mysql_query("SELECT id_b, base_b from bases where id_b = $base ", $horizonte) or die (mysql_error());
	 $rowC = mysql_fetch_row($resultC);
	 
 $idB = sqlValue($rowC[0], "int");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
	
 mysql_select_db($database_horizonte, $horizonte); 
$sql="INSERT INTO asignar_bases(aleatorio_ab,id_base_ab,usuario_reg_ab,fecha_reg_ab,id_estudio_ab)";
$sql.= "VALUES ($noTemp, $idB, $idU, $now, $idE)";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) { echo $sql; }else{  echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>