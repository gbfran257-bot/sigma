<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $noTemp = sqlValue($_POST["noAleatorio"], "text");
 $muestra = sqlValue($_POST["muestra"], "int");
 $idU = sqlValue($_POST["idU"], "int");

 mysql_select_db($database_horizonte, $horizonte); 
 $resultC = mysql_query("SELECT id_mu, id_condicion_mu from muestras where id_mu = $muestra ", $horizonte) or die (mysql_error());
 $rowC = mysql_fetch_row($resultC);
 
 mysql_select_db($database_horizonte, $horizonte); 
 $resultC1 = mysql_query("SELECT count(id_am) from asignar_muestra where id_muestra_am = $muestra and aleatorio_am = $noTemp", $horizonte) or die (mysql_error());
 $rowC1 = mysql_fetch_row($resultC1);
	 
 $idM = sqlValue($rowC[0], "int");
 $idCondicion = sqlValue($rowC[1], "int");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 
 if($rowC1[0]<1){
 	mysql_select_db($database_horizonte, $horizonte); 
 	$sql="INSERT INTO asignar_muestra(aleatorio_am,id_muestra_am,usuario_am,fecha_am)";
 	$sql.= "VALUES ($noTemp, $idM, $idU, $now)";
	$update = mysql_query($sql, $horizonte) or die (mysql_error());
    if (!$update) { echo $sql; }else{ echo 1; }
 }else{echo 1;}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>