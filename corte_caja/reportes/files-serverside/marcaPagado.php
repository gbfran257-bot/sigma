<?php
session_start();

require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");
//Generales 
 
mysql_select_db($database_horizonte, $horizonte);
$resultHl = mysql_query("insert into pagos_s (monto, usuario) values (".$_POST['monto'].", ".$_SESSION['id'].")",$horizonte) or die (mysql_error());
$id = mysql_insert_id();
foreach($_POST['datos'] as $v){
	$resultHl = mysql_query("insert into pagos_sucursal (idPS, id_ov, usuario) values ($id, $v, ".$_SESSION['id'].")",$horizonte) or die (mysql_error());
}
	
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>