<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$motivo_alteracion = sqlValue($_POST["motivo_alteracion"], "text");
$id_vc = sqlValue($_POST["id_vc"], "int");
$precio_original = sqlValue($_POST["precio_original"], "double");
$descuento = sqlValue($_POST['descuento'], 'double');


mysql_select_db($database_horizonte, $horizonte); 
$sql="update venta_conceptos set motivo_alteracion=$motivo_alteracion, precio_vc=$precio_original, precio_original=$precio_original, descuento=$descuento where id_vc=$id_vc";
$update = mysql_query($sql, $horizonte) or die (mysql_error());
if (!$update) { echo $sql; }else{ 
	echo 1;
}
//Cerrar conexión a la Base de Datos
mysql_close($horizonte);
