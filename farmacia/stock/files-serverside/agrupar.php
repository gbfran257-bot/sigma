<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

//primero obtenemos los datos del stock
mysql_select_db($database_horizonte, $horizonte); 
$qryStock = mysql_query("SELECT Lote, id_stock, id_Producto, fecha_expiracion FROM stock_has_bach WHERE id = " . $_POST['id'],$horizonte) or die (mysql_error());
$stock = mysql_fetch_row($qryStock);

//obtenemos la suma de existencias
mysql_select_db($database_horizonte, $horizonte); 
$qrySuma = mysql_query("SELECT SUM(existencias) FROM stock_has_bach WHERE Lote = '$stock[0]' AND id_stock = $stock[1] AND id_Producto = $stock[2] AND fecha_expiracion = '$stock[3]'",$horizonte) or die (mysql_error());
$suma = mysql_fetch_row($qrySuma);

//primero actualizamos la existencia del registro
mysql_select_db($database_horizonte, $horizonte);
$qry_upd = "UPDATE stock_has_bach SET existencias = $suma[0] WHERE id = " . $_POST['id'] . " LIMIT 1"; 
$upd1 = mysql_query($qry_upd, $horizonte) or die (mysql_error());

//si se actualiza ponemos el resto en 0 a excepcion del que sumamos antes
if($upd1){
    mysql_select_db($database_horizonte, $horizonte);
    $qry_upd2 = "UPDATE stock_has_bach SET existencias = 0 WHERE Lote = '$stock[0]' AND id_stock = $stock[1] AND id_Producto = $stock[2] AND fecha_expiracion = '$stock[3]' AND id NOT IN (".$_POST['id'].")"; 
    $upd2 = mysql_query($qry_upd2, $horizonte) or die (mysql_error());
}

if($upd2){
    echo 1;
}else{
    echo "error";
}

//Cerrar conexión a la Base de Datos
mysql_close($horizonte);
?>
