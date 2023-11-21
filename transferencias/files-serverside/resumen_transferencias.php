<?php

try {
    $referencia = htmlentities($_GET['referencia'], ENT_QUOTES, "utf-8");

    include_once("../../Connections/horizonte2.php");

    // Obtenemos la referencia de la orden de los traspasos
    $query_id_temporal = "SELECT referencia_traspaso_temporal AS id_temporal FROM stock_has_bach WHERE referencia_compra = \"{$referencia}\" AND referencia_traspaso_temporal != \"\" LIMIT 1";
    $resultado_query_id_temporal = mysqli_query($horizonte, $query_id_temporal);
    $id_temporal = mysqli_fetch_object($resultado_query_id_temporal)->id_temporal;

    // Obtenemos la cantidad de producto, el id de cada producto y la cantidad transferida
    $query_datos_traspaso_temporal = "SELECT tt.id_producto AS id, tt.producto, tt.cantidad_transferir AS cantidad FROM transferencia_temporal tt WHERE tt.id_temporal = \"{$id_temporal}\"";
    $resultado_query_datos_traspaso_temporal = mysqli_query($horizonte, $query_datos_traspaso_temporal);
    $datos_traspaso_temporal = mysqli_fetch_all($resultado_query_datos_traspaso_temporal, MYSQLI_ASSOC);
    $num_transferencias = mysqli_num_rows($resultado_query_datos_traspaso_temporal);

    // Obtenemos el precio unitario y el total
    $query_datos_stock = "SELECT shb.id AS id, shb.costo_unitario AS precio_unitario, shb.costo_unitario * shb.cantidad AS total FROM stock_has_bach shb WHERE shb.referencia_traspaso_temporal = \"{$id_temporal}\"";
    $resultado_query_datos_stock = mysqli_query($horizonte, $query_datos_stock);
    $datos_stock = mysqli_fetch_all($resultado_query_datos_stock, MYSQLI_ASSOC);

    // Obtenemos el usuario, fecha y hora que realizó los traspasos
    $query_usuario_fecha_hora = "SELECT CONCAT(u.usuario_u, \" \", DATE_FORMAT(s.fecha_update, \"%d/%c/%Y\"), \" \", DATE_FORMAT(s.fecha_update, \"%H:%i:%s\")) AS usuario_fecha_hora FROM stock_has_bach s LEFT JOIN usuarios u ON s.usuario_registro = u.id_u WHERE s.referencia_compra = \"{$referencia}\" LIMIT 1";
    $resultado_query_usuario_fecha_hora = mysqli_query($horizonte, $query_usuario_fecha_hora);
    $usuario_fecha_hora = mysqli_fetch_object($resultado_query_usuario_fecha_hora)->usuario_fecha_hora;

    $transferencias = [
        "usuario_fecha_hora" => $usuario_fecha_hora,
        "num_transferencias" => $num_transferencias,
        "transferencias" => $datos_traspaso_temporal,
        "datos_stock" => $datos_stock,
    ];

    echo json_encode($transferencias);
} catch (\Exception $ex) {
    echo json_encode(['error' => $ex->getMessage()]);
}

die();
