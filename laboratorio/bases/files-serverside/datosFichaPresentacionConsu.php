<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $id = sqlValue($_POST["idPco"], "int"); 
 
 	mysql_select_db($database_horizonte, $horizonte);
 	$result = mysql_query("SELECT presentacion_cp from catalogo_presentaciones where id_cp = $id ", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result);

	echo $row[0]."{;]".$row[0];
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>