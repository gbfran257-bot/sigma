<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");
$temp = sqlValue($_POST["temp"], "text");
$area = sqlValue($_POST["area"], "text");
mysql_select_db($database_horizonte, $horizonte); 
// UPDATE conceptos_carg_desc SET monto = 0 WHERE no_temp_cd = '2023-07-02-12-10-34-19' AND tipo = 1 AND tipo_area = 'laboratorio';

$sql = "UPDATE conceptos_carg_desc SET monto = 0 WHERE no_temp_cd = $temp AND tipo = 1 AND tipo_area = $area";
echo $sql;
$update = mysql_query($sql, $horizonte) or die (mysql_error());
if (!$update) { echo $sql; }else{ 
	$dat = mysql_fetch_row($update);
	echo json_encode($dat);
}

//Cerrar conexión a la Base de Datos
mysql_close($horizonte);
?>