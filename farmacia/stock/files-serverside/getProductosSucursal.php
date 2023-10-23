<?php

try {
    require("../../../Connections/horizonte2.php");

    $id_sucursal = intval(htmlspecialchars($_GET['id_s'], ENT_QUOTES, "utf-8"));

    $query_productos_sucursal = "SELECT
                                    c.concepto_to AS producto,
                                    codigo_barras_to AS codigo_barras,
                                    nombre_a AS area,
                                    precio_to AS precio,
                                    Lote AS lote,
                                    cantidad AS stock,
                                    DATE_FORMAT(fecha_expiracion, '%d-%m-%Y') AS caducidad
                                FROM stock_has_bach shb
                                LEFT JOIN stock s ON shb.id_stock = s.id
                                LEFT JOIN conceptos c ON shb.id_Producto = c.id_to
                                LEFT JOIN areas a ON c.id_area_to = a.id_a
                                WHERE s.id_su = {$id_sucursal}
                                ORDER BY producto";

    if (!$resultado_query_productos_sucursal = mysqli_query($horizonte, $query_productos_sucursal)) {
        throw new Exception(mysqli_error($horizonte));
    }

    echo json_encode(mysqli_fetch_all($resultado_query_productos_sucursal, MYSQLI_ASSOC));
} catch (\Exception $ex) {
    echo json_encode(['error' => $ex->getMessage()]);
}

die();
