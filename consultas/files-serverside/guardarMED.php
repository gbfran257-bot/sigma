<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idMED = sqlValue($_POST["idMED"], "int");
 $idP = sqlValue($_POST["idP"], "int");
 $idU = sqlValue($_POST["idU"], "int");
 $idC = sqlValue($_POST["idC"], "int");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");

 mysql_select_db($database_horizonte, $horizonte); 
 $resultI = mysql_query("SELECT descripcion_to from conceptos where id_to = $idMED limit 1 ", $horizonte) or die (mysql_error());
 $rowI = mysql_fetch_row($resultI); $indi = sqlValue($rowI[0], "text");
 
 mysql_select_db($database_horizonte, $horizonte); 
 $result = mysql_query("SELECT count(id_mr) from medicamentos_receta where id_co_mr = $idC and id_med_mr = $idMED", $horizonte) or die (mysql_error());
 $row = mysql_fetch_row($result);
 
 if($row[0]<1){
	 mysql_select_db($database_horizonte, $horizonte); 
	 $sql="INSERT INTO medicamentos_receta(id_p_mr,id_u_mr,id_med_mr,fecha_mr, id_co_mr) VALUES ($idP, $idU, $idMED, $now, $idC)";
	  
	 $update = mysql_query($sql, $horizonte) or die (mysql_error());
		
	 if (!$update) { echo $sql; }else{  echo 1; }
 }else{ echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>