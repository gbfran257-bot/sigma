<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	$idP = sqlValue($_POST["idP"], "int");
	$idH = sqlValue($_POST["idH"], "int");
	
		mysql_select_db($database_horizonte, $horizonte);
		$result1 = mysql_query("SELECT nota_nh, id_nh from notas_de_hospital where id_hospitalizacion_nh = $idH limit 1 ", $horizonte) or die (mysql_error());
		$row1 = mysql_fetch_row($result1);
			
	echo $row1[1];
 	//Cerrar conexión a la Base de Datos
 	mysql_close($horizonte);
?>