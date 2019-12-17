<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $valor = sqlValue($_POST["val"], "double");
 $id_to = sqlValue($_POST["id_to"], "int");
 $id_u = sqlValue($_POST["id_u"], "int");
 $id_su = sqlValue($_POST["id_su"], "int");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");

 //Checamos si hay cambio, sino hay cambio entonces no se actualiza
 mysql_select_db($database_horizonte, $horizonte);
 $result = mysql_query("SELECT precio_to from conceptos where id_to = $id_to ", $horizonte) or die (mysql_error());
 $row = mysql_fetch_row($result);

 if($row[0] < $valor or $row[0] > $valor){
	 mysql_select_db($database_horizonte, $horizonte);
	 $sql = "UPDATE conceptos set precio_to = $valor, usuario_to = $id_u, fecha_to = $now where id_to = $id_to";
	 $update = mysql_query($sql, $horizonte) or die (mysql_error());

	 if (!$update) { echo $sql; }else{ echo 1; } 
 }else{echo 1;}
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>