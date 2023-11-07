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
        $query_sucursal_origen = "SELECT nombre_su FROM sucursales WHERE id_su = {$producto->id_sucursal_origen}";
        $query_sucursal_destino = "SELECT nombre_su FROM sucursales WHERE id_su = {$producto->id_sucursal_destino}";

        if (!$resultado_query_sucursal_origen = mysqli_query($horizonte, $query_sucursal_origen)) {
            throw new Exception(mysqli_error($horizonte));
        }
        if (!$resultado_query_sucursal_destino = mysqli_query($horizonte, $query_sucursal_destino)) {
            throw new Exception(mysqli_error($horizonte));
        }

        $sucursal_origen = mysqli_fetch_object($resultado_query_sucursal_origen);
        $sucursal_destino = mysqli_fetch_object($resultado_query_sucursal_destino);

        $producto_seleccionado = [
            "producto" => $producto->producto,
            "codigo_barras" => $producto->codigo_barras,
            "lote" => $producto->lote,
            "sucursal_origen" => $sucursal_origen->nombre_su,
            "sucursal_destino" => $sucursal_destino->nombre_su,
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
