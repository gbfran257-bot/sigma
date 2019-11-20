<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idEstudio = sqlValue($_POST["idEstudio"], "int");
 $noImgen = sqlValue($_POST["noImgen"], "int");

	mysql_select_db($database_horizonte, $horizonte);
	$result = mysql_query("select editada_ie from img_endoscopia where id_estudio_vc_ie = $idEstudio and imagen_ie = $noImgen limit 1 ", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result);
	
	echo $row[0];

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>