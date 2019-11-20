<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $noTemp = sqlValue($_POST["noAleatorio"], "text");
 $consumible = sqlValue($_POST["consumible"], "int");
 $idU = sqlValue($_POST["idU"], "int");

 mysql_select_db($database_horizonte, $horizonte); 
 $resultC = mysql_query("SELECT id_i, item_i from inventario where id_i = $consumible ", $horizonte) or die (mysql_error());
 $rowC = mysql_fetch_row($resultC);
	 
 $idI = sqlValue($rowC[0], "int");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 
 mysql_select_db($database_horizonte, $horizonte); 
 $resultC1 = mysql_query("SELECT count(id_ac) from asignar_consumibles where id_item_ac = $consumible and aleatorio_ac = $noTemp", $horizonte) or die (mysql_error());
 $rowC1 = mysql_fetch_row($resultC1);
 
 if($rowC1[0]<1){
	 mysql_select_db($database_horizonte, $horizonte); 
	 $sql="INSERT INTO asignar_consumibles(aleatorio_ac,id_item_ac,usuario_ac,fecha_ac)";
	 $sql.= "VALUES ($noTemp, $idI, $idU, $now)";
	 $update = mysql_query($sql, $horizonte) or die (mysql_error());	
	 if (!$update) { echo $sql; }else{ echo 1; }
 }else{echo 1;}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>