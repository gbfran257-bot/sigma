<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idP=sqlValue($_POST["idP"],"int"); $idU=sqlValue($_POST["idU"],"int"); $idE = sqlValue($_POST["idE"], "int");

	mysql_select_db($database_horizonte, $horizonte);
	$result = mysql_query("SELECT v.nota_receta from venta_conceptos v where v.id_vc = $idE ", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result);
 	$row[0] = str_replace("../../../escuelas/logotipos/files/", "escuelas/logotipos/files/", $row[0]);
 	$row[0] = str_replace("../../../imagenes/generales/", "imagenes/generales/", $row[0]);
		echo $row[0];
	
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>
