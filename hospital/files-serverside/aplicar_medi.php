<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	$id_mh = sqlValue($_POST["id_mh"], "int");
	$id_u = sqlValue($_POST["id_u"], "int");
	$now = sqlValue(date('Y-m-d H:i:s'), "date");

	mysql_select_db($database_horizonte, $horizonte);
	$sql = "INSERT INTO medicamentos_aplicados_hospi(id_medicamento_hospital_mah, id_usuario_mah, fecha_mah) values($id_mh, $id_u, $now)";
	$update = mysql_query($sql, $horizonte) or die (mysql_error());

	if(!$update){echo $sql;} else{ echo 1; }

 	//Cerrar conexión a la Base de Datos
 	mysql_close($horizonte);
?>