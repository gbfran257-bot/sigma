<?php

try {
    $id_transferencia_temporal = $_GET['id_t_t'];

    require("../../../Connections/horizonte2.php");

    $query_productos_seleccionados = "SELECT * FROM transferencia_temporal WHERE id_temporal = '{$id_transferencia_temporal}'";

    if (!$resultado_query = mysqli_query($horizonte, $query_productos_seleccionados)) {
        throw new Exception(mysqli_error($horizonte));
    }

    $productos_seleccionados = [];
    while ($producto = mysqli_fetch_object($resultado_query)) {
        $producto_seleccionado = [
            "producto" => $producto->producto,
            "codigo_barras" => $producto->codigo_barras,
            "lote" => $producto->lote,
            "sucursal_origen" => $producto->id_sucursal_origen,
            "sucursal_destino" => $producto->id_sucursal_destino,
            "cantidad_transferir" => $producto->cantidad_transferir,
            "acciones" => "<button type'button' class='btn btn-sm bg-danger' onClick=''>Eliminar</button>"
        ];
        array_push($productos_seleccionados, $producto_seleccionado);
    }
    echo json_encode($productos_seleccionados);

    mysqli_close($horizonte);
} catch (\Exception $ex) {
    echo json_encode(['error' => $ex->getMessage()]);
}

die();
