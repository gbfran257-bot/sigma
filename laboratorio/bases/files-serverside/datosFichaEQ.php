<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $idE = sqlValue($_POST["idEqui"], "int"); 
 
 	mysql_select_db($database_horizonte, $horizonte);
 	$result = mysql_query("SELECT modelo_eq, marca_eq, descripcion_eq from catalogo_equipos where id_eq = $idE ", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result);

	echo $row[0]."{;]".$row[1]."{;]".$row[2];
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>