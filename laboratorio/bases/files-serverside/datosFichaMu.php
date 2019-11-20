<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $id = sqlValue($_POST["idMu"], "int"); 
 
 	mysql_select_db($database_horizonte, $horizonte);
 	$result = mysql_query("SELECT muestra_mu, id_condicion_mu from muestras where id_mu = $id ", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result);

	echo $row[0]."{;]".$row[1];
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>