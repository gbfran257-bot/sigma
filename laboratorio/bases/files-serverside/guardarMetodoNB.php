<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $noTemp = sqlValue($_POST["noAleatorio"], "text");
 $metodo = sqlValue($_POST["metodo"], "int");
 $idU = sqlValue($_POST["idU"], "int");

 mysql_select_db($database_horizonte, $horizonte); 
 $resultC = mysql_query("SELECT id_me, metodo_me from metodos where id_me = $metodo ", $horizonte) or die (mysql_error());
 $rowC = mysql_fetch_row($resultC);
 
 mysql_select_db($database_horizonte, $horizonte); 
 $resultC1 = mysql_query("SELECT count(id_ame) from asignar_metodo where id_metodo_ame = $metodo and aleatorio_ame = $noTemp", $horizonte) or die (mysql_error());
 $rowC1 = mysql_fetch_row($resultC1);
	 
 $idM = sqlValue($rowC[0], "int");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");

 if($rowC1[0]<1){
	 mysql_select_db($database_horizonte, $horizonte); 
	 $sql="INSERT INTO asignar_metodo(aleatorio_ame,id_metodo_ame,usuario_ame,fecha_ame)";
	 $sql.= "VALUES ($noTemp, $idM, $idU, $now)";
	 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	 if (!$update) { echo $sql; }else{ echo 1; }
 }else{ echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>