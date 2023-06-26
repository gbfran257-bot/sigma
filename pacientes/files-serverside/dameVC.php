<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");
$id_vc = sqlValue($_POST["id_vc"], "int");
mysql_select_db($database_horizonte, $horizonte); 
$sql="select precio_vc, honorarios, precio_original, descuento, motivo_alteracion from venta_conceptos where id_vc=$id_vc";
$update = mysql_query($sql, $horizonte) or die (mysql_error());
if (!$update) { echo $sql; }else{ 
	$dat = mysql_fetch_row($update);
	echo json_encode($dat);
}

//Cerrar conexión a la Base de Datos
mysql_close($horizonte);
?>