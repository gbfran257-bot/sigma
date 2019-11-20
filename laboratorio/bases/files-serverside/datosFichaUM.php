<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $idUM = sqlValue($_POST["idUM"], "int"); 
 
 	mysql_select_db($database_horizonte, $horizonte);
 	$result = mysql_query("SELECT unidad_un, abreviacion_un from unidades where id_un = $idUM ", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result);

	echo $row[0]."{;]".$row[1];
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>