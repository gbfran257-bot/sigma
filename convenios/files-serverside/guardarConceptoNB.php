<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $noTemp = sqlValue($_POST["noAleatorio"], "text");
 $concepto = sqlValue($_POST["concepto"], "int");
 $idU = sqlValue($_POST["idU"], "int");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
	
 mysql_select_db($database_horizonte, $horizonte); 
 $sql="INSERT INTO asigna_conceptos_convenios(aleatorio_ac,id_concepto_ac,usuario_ac,fecha_ac)";
 $sql.= "VALUES ($noTemp, $concepto, $idU, $now)";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) { echo $sql; }else{  echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>