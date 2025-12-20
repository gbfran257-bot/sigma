<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	$id_mh = sqlValue($_POST["id_mh"], "int");
	
    mysql_select_db($database_horizonte, $horizonte);
    $result1 = mysql_query("SELECT indicacion_mh from medicamentos_hospital where id_mh = $id_mh limit 1 ", $horizonte) or die (mysql_error());
    $row1 = mysql_fetch_row($result1);
			
	echo $row1[0];
 	//Cerrar conexión a la Base de Datos
 	mysql_close($horizonte);
?>