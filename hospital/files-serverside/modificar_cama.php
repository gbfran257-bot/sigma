<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

	//$id_cama_h = sqlValue($_POST["id_cama_h"], "int");
	$id_cama_nueva = sqlValue($_POST["id_cama_nueva"], "int");
	$id_h = sqlValue($_POST["id_h"], "int");

	//Verificamos si el paciente se encuentra hospitalizado.
	mysql_select_db($database_horizonte, $horizonte);
	$qry_estado_h = mysql_query("SELECT COUNT(*), id_cama_h FROM hospitalizacion WHERE  id_h = $id_h AND estatus_h = 13", $horizonte) or die (mysql_error());
	$estado_h = mysql_fetch_row($qry_estado_h);

	if($estado_h[0] >= 1){
		mysql_select_db($database_horizonte, $horizonte);
		$liberarCama = mysql_query("UPDATE camas SET ocupado_ca = 0 WHERE id_ca = $estado_h[1] AND ocupado_ca = 1 LIMIT 1", $horizonte) or die (mysql_error());
	
		if($liberarCama){
			mysql_select_db($database_horizonte, $horizonte);
			$actualizarCama = mysql_query("UPDATE hospitalizacion SET id_cama_h = $id_cama_nueva WHERE id_h = $id_h LIMIT 1", $horizonte) or die (mysql_error());
			if($actualizarCama){
				//Verificamos nuevamente la cama asignada al paciente de la tabla hospitalizacion.
				mysql_select_db($database_horizonte, $horizonte);
				$qry_cama_p = mysql_query("SELECT id_cama_h FROM hospitalizacion WHERE  id_h = $id_h AND estatus_h = 13", $horizonte) or die (mysql_error());
				$cama_p = mysql_fetch_row($qry_cama_p);

				mysql_select_db($database_horizonte, $horizonte);
				$ocuparCama = mysql_query("UPDATE camas SET ocupado_ca = 1 WHERE id_ca = $cama_p[0] AND ocupado_ca = 0 LIMIT 1", $horizonte) or die (mysql_error());
				if($ocuparCama){
					echo 1;
				}
			}else{
				echo 2;
			}
		}else{
			echo 2;
		}
	}else{
		echo "El paciente se encuentra en estado EGRESADO";
	}


 	//Cerrar conexión a la Base de Datos
 	mysql_close($horizonte);
?>
