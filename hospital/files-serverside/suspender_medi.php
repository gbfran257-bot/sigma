<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	// $id_h = sqlValue($_POST["id_h"], "int");
	$id_mh = sqlValue($_POST["id_mh"], "int");
	$notaS = sqlValue($_POST["notaS"], "text");
	$id_u = sqlValue($_POST["id_u"], "int");
	$now = sqlValue(date('Y-m-d H:i:s'), "date");
	// $estatus = 18; //id 18 del catalogo de estatus es Aplicar 

	mysql_select_db($database_horizonte, $horizonte);
 	$result = mysql_query("UPDATE medicamentos_hospital SET estatus_mh = 19, nota_medica_mh = $notaS where id_mh = $id_mh ", $horizonte) or die (mysql_error());

	if($result){
		mysql_select_db($database_horizonte, $horizonte);
		$sql = "INSERT INTO suspension_medicamento_hospital(id_s,id_user_s, fecha_s, id_mh_s, nota_s) values(null, $id_u, $now, $id_mh,$notaS)";
		$update = mysql_query($sql, $horizonte) or die (mysql_error());

		if(!$update){echo $sql;} else{ echo 1; }
	}

 	//Cerrar conexión a la Base de Datos
 	mysql_close($horizonte);
?>
