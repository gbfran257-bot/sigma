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
        // Consultamos el nombre de la sucursal de origen y de destino
        $query_sucursales_producto = "SELECT nombre_su FROM sucursales WHERE id_su = {$producto->id_sucursal_origen} OR id_su = {$producto->id_sucursal_destino}";

        if (!$resultado_query_sucursales = mysqli_query($horizonte, $query_sucursales_producto)) {
            throw new Exception(mysqli_error($horizonte));
        }

        $sucursales = mysqli_fetch_all($resultado_query_sucursales);

        $producto_seleccionado = [
            "producto" => $producto->producto,
            "codigo_barras" => $producto->codigo_barras,
            "lote" => $producto->lote,
            "sucursal_origen" => $sucursales[0][0],
            "sucursal_destino" => $sucursales[1][0],
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
