<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$id_to = sqlValue($_POST["id_to"], "int");

mysql_select_db($database_horizonte, $horizonte); 
$sql="SELECT concepto_to, indicaciones_med from medicamentos left join conceptos on id_medicamento_g = id_med where id_to=$id_to";
$update = mysql_query($sql, $horizonte) or die (mysql_error());
if (!$update) { echo $sql; }else{ 
	$dat = mysql_fetch_row($update);
	echo json_encode($dat);
}

//Cerrar conexión a la Base de Datos
mysql_close($horizonte);
?>