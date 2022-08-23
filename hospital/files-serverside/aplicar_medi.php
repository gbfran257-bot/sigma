<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	$id_mh = sqlValue($_POST["id_mh"], "int");
	$id_u = sqlValue($_POST["id_u"], "int");
	$now = sqlValue(date('Y-m-d H:i:s'), "date");
	$banderaExistencias = false;
	$idExistencias = 0;
	$cantExistencias = 0;

	mysql_select_db($database_horizonte, $horizonte);
	$id_c = "SELECT id_medicamento_mh from medicamentos_hospital where id_mh = $id_mh";
	$id_concepto = mysql_query($id_c, $horizonte) or die (mysql_error());
	$id_con = mysql_fetch_row($id_concepto);
	$medicamento = $id_con[0];


		mysql_select_db($database_horizonte, $horizonte);
		$sql = "INSERT INTO medicamentos_aplicados_hospi(id_medicamento_hospital_mah, id_usuario_mah, fecha_mah) values($id_mh, $id_u, $now)";
		$update = mysql_query($sql, $horizonte) or die (mysql_error());

		if(!$update){
			echo $sql;
		} 
		else{ 
		}
		

 	//Cerrar conexión a la Base de Datos
 	mysql_close($horizonte);
?>
