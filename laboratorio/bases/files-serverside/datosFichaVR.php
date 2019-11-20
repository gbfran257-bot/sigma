<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $id = sqlValue($_POST["idVr"], "int"); 
 
 	mysql_select_db($database_horizonte, $horizonte);
 	$result = mysql_query("SELECT valor_referencia_vr, tipo_vr, descripcion_vr from valores_referencia where id_vr = $id ", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result);

	echo $row[0]."{;]".$row[1]."{;]".$row[2];
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>