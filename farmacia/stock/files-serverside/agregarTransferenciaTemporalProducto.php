<?php

try {
    $id_transferencia_temporal = $_POST['id_transferencia_temporal'];
    $id_transferencia = $_POST['id_transferencia'];
    $cantidad_transferir = htmlentities($_POST['cantidad_transferir'], ENT_QUOTES, "utf-8");
    $id_sucursal_origen = intval(htmlentities($_POST['id_sucursal_origen'], ENT_QUOTES, "utf-8"));
    $id_sucursal_destino = intval(htmlentities($_POST['id_sucursal_destino'], ENT_QUOTES, "utf-8"));
    $id_producto_seleccionado = intval(htmlentities($_POST['id_producto_seleccionado'], ENT_QUOTES, "utf-8"));
    $nombre_producto_seleccionado = htmlentities($_POST['nombre_producto_seleccionado'], ENT_QUOTES, "utf-8");
    $producto_seleccionado = json_decode($_POST['producto']);

    require("../../../Connections/horizonte2.php");

    // Verificamos si ya hay una transferencia previa del producto seleccionado
    $query_verificar_transferencia = "SELECT COUNT(producto) AS existencia FROM transferencia_temporal WHERE id_temporal = '{$id_transferencia_temporal}' AND id_producto = {$id_producto_seleccionado} AND lote = '{$producto_seleccionado->lote}'";
    if (!$resultado__verificar_transferencia = mysqli_query($horizonte, $query_verificar_transferencia)) {
        throw new Exception(mysqli_error($horizonte));
    }

    $existe_transferencia_producto = mysqli_fetch_object($resultado__verificar_transferencia)->existencia;

    // si existe una transferencia previa actualizamos la cantidad a transferir sino hacemos el insert normal
    $fecha = date("Y-m-d H:i:s");
    $query = "";
    if ($existe_transferencia_producto == 1) {
        $query = "UPDATE transferencia_temporal SET cantidad_transferir = {$cantidad_transferir}, id_sucursal_destino = {$id_sucursal_destino} WHERE id_temporal = '{$id_transferencia_temporal}' AND id_producto = {$id_producto_seleccionado}";
    } else {
        $query = "INSERT INTO transferencia_temporal VALUES('{$id_transferencia_temporal}', '{$nombre_producto_seleccionado}', '{$producto_seleccionado->nombre_generico}', '{$producto_seleccionado->lote}', '{$producto_seleccionado->caducidad}', {$cantidad_transferir}, {$id_sucursal_origen}, {$id_sucursal_destino}, {$id_producto_seleccionado}, '{$fecha}', '{$id_transferencia}', 0)";
    }

    if (!$resultado_query = mysqli_query($horizonte, $query)) {
        throw new Exception(mysqli_error($horizonte));
    }

    echo json_encode(['success' => "Producto agregado correctamente."]);
} catch (\Exception $ex) {
    echo json_encode(['error' => $ex->getMessage()]);
}

die();
