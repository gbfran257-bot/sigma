<?php

try {
    require("../../../Connections/horizonte2.php");

    $id_sucursal = intval(htmlspecialchars($_GET['id_s'], ENT_QUOTES, "utf-8"));

    $query_productos_sucursal = "SELECT
                                    c.id_to AS id_producto,
                                    c.concepto_to AS producto,
                                    m.nombre_generico_med AS nombre_generico,
                                    Lote AS lote,
                                    existencias AS stock,
                                    DATE_FORMAT(fecha_expiracion, '%d-%m-%Y') AS caducidad,
                                    shb.id AS id_stock_hb
                                FROM stock_has_bach shb
                                LEFT JOIN stock s ON shb.id_stock = s.id
                                LEFT JOIN conceptos c ON shb.id_Producto = c.id_to
                                LEFT JOIN medicamentos m ON c.id_medicamento_g = m.id_med
                                WHERE s.id_su = {$id_sucursal} AND shb.existencias > 0
                                ORDER BY producto";

    if (!$resultado_query_productos_sucursal = mysqli_query($horizonte, $query_productos_sucursal)) {
        throw new Exception(mysqli_error($horizonte));
    }

    $productos_sucursal = [];
    while ($producto = mysqli_fetch_object($resultado_query_productos_sucursal)) {
        array_push($productos_sucursal, [
            "producto" => "<span id='producto-seleccionado-temporal' id_p='{$producto->id_producto}'>{$producto->producto}</span>",
            "nombre_generico" => $producto->nombre_generico,
            "lote" => $producto->lote,
            "stock" => $producto->stock,
            "caducidad" => $producto->caducidad,
            "id_stock_hb" => $producto->id_stock_hb,
        ]);
    }

    echo json_encode($productos_sucursal);
} catch (\Exception $ex) {
    echo json_encode(['error' => $ex->getMessage()]);
}

die();
