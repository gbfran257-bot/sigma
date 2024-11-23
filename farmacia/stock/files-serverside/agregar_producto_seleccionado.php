<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

$now = sqlValue(date('Y-m-d H:i:s'), "date");
$id_temporal = sqlValue($_POST['id_temporal'], 'text');
$sucursal_origen = sqlValue($_POST['sucursal_origen'], 'int');
$sucursal_destino = sqlValue($_POST['sucursal_destino'], 'int');
$id_stock = sqlValue($_POST['id_stock'], 'int');
$id_transferencia = sqlValue($_POST['id_transferencia'], 'text');

//Datos adicionales del producto
mysql_select_db($database_horizonte, $horizonte);
$qryDatos = mysql_query("SELECT shb.lote, shb.fecha_expiracion, c.concepto_to, m.nombre_generico_med, shb.id_Producto FROM stock_has_bach shb LEFT JOIN conceptos c ON c.id_to = shb.id_Producto LEFT JOIN medicamentos m ON m.id_med = c.id_medicamento_g WHERE shb.id = ".$id_stock, $horizonte) or die(mysql_error());
$datos = mysql_fetch_row($qryDatos);

$producto = sqlValue($datos[2], 'text');
$nombre_generico = sqlValue($datos[3], 'text');
$lote = sqlValue($datos[0], 'text');
$caducidad = sqlValue($datos[1], 'date');
$id_producto = sqlValue($datos[4], 'int');

//verificamos si el producto ya fue agregado con anterioridad.
mysql_select_db($database_horizonte, $horizonte);
$qryContador = mysql_query("SELECT COUNT(producto) FROM transferencia_temporal WHERE id_temporal = $id_temporal AND id_producto = $id_producto AND lote = $lote", $horizonte) or die(mysql_error());
$contador = mysql_fetch_row($qryContador);

if($contador[0]==0){
    mysql_select_db($database_horizonte, $horizonte);
    $qryAddRegistro = "INSERT INTO transferencia_temporal (id_temporal, producto, nombre_generico, lote, caducidad, cantidad_transferir, id_sucursal_origen, id_sucursal_destino, id_producto, fecha_transferencia, id_transferencia, id_usuario_receptor, fecha_recepcion) VALUES ($id_temporal, $producto, $nombre_generico, $lote, $caducidad, '1', $sucursal_origen, $sucursal_destino, $id_producto, $now, $id_transferencia, '0', '0000-00-00 00:00:00')";
    $update = mysql_query($qryAddRegistro, $horizonte) or die (mysql_error());
        
    if(!$update) {
        echo $sql; 
    }else{
        echo 1;
    }
}else{
    echo 2;
}



 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>