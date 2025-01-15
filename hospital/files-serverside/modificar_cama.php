<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

	$id_cama_h = sqlValue($_POST["id_cama_h"], "int");
	$id_cama_nueva = sqlValue($_POST["id_cama_nueva"], "int");
	$id_h = sqlValue($_POST["id_h"], "int");

	mysql_select_db($database_horizonte, $horizonte);
 	$liberarCama = mysql_query("UPDATE camas SET ocupado_ca = 0 WHERE id_ca = $id_cama_h AND ocupado_ca = 1 LIMIT 1", $horizonte) or die (mysql_error());

	if($liberarCama){
		mysql_select_db($database_horizonte, $horizonte);
		$actualizarCama = mysql_query("UPDATE hospitalizacion SET id_cama_h = $id_cama_nueva WHERE id_h = $id_h LIMIT 1", $horizonte) or die (mysql_error());
		if($actualizarCama){
			mysql_select_db($database_horizonte, $horizonte);
			$ocuparCama = mysql_query("UPDATE camas SET ocupado_ca = 1 WHERE id_ca = $id_cama_nueva AND ocupado_ca = 0 LIMIT 1", $horizonte) or die (mysql_error());
			if($ocuparCama){
				echo 1;
			}
		}else{
			echo 2;
		}
	}else{
		echo 2;
	}

 	//Cerrar conexión a la Base de Datos
 	mysql_close($horizonte);
?>
