<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

	$id_mh = sqlValue($_POST["id_mh"], "int");

	//Revisamos si el medicamento no está asignado en la hospiralización
	mysql_select_db($database_horizonte, $horizonte);
 	$result = mysql_query("SELECT estatus_mh from medicamentos_hospital where id_mh = $id_mh", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result);

	if($row[0] == 18){ //18 en catálogo de estatus es aplicar
		echo 1;
	}else if($row[0] == 19){ //19 en catálogo de estatus es suspender
        echo 2;
    }else{
        echo "ocurrio un error";
    }

 	//Cerrar conexión a la Base de Datos
 	mysql_close($horizonte);
?>