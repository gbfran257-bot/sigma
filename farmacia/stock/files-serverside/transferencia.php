<?php

try {
    $id_transferencia_temporal = $_POST['id_t_t'];
    $id_usuario = intval($_POST['id_u']);

    require("../../../Connections/horizonte2.php");

    $query_transferencias_temporales = "SELECT * FROM transferencia_temporal WHERE id_temporal = '{$id_transferencia_temporal}'";

    if (!$resultado_query_transferencias = mysqli_query($horizonte, $query_transferencias_temporales)) {
        throw new Exception(mysqli_error($horizonte));
    }


    while ($transferencia_temporal = mysqli_fetch_assoc($resultado_query_transferencias)) {
        // Restamos la cantidad a transferir de la existencia del stock correspondiente al producto seleccionado (origen)
        $query_resta_stock = "UPDATE stock_has_bach shb
                              LEFT JOIN stock s ON shb.id_stock = s.id
                              SET existencias = existencias - {$transferencia_temporal['cantidad_transferir']}, fecha_update = NOW()
                              WHERE shb.id_Producto = {$transferencia_temporal['id_producto']} AND Lote = '{$transferencia_temporal['lote']}' AND s.id_su = {$transferencia_temporal['id_sucursal_origen']}";
        if (!$resultado_query_resta_stock = mysqli_query($horizonte, $query_resta_stock)) {
            throw new Exception(mysqli_error($horizonte));
        }

        // Sumamos la cantidad a transferir a la existencia del stock correspondiente al producto seleccionado (destino)
        $query_existencia_stock = "SELECT *
                                   FROM stock_has_bach shb
                                   LEFT JOIN stock s ON shb.id_stock = s.id
                                   WHERE shb.id_Producto = {$transferencia_temporal['id_producto']} AND Lote = '{$transferencia_temporal['lote']}' AND s.id_su = {$transferencia_temporal['id_sucursal_destino']}";
        if (!$resultado_existencia_stock = mysqli_query($horizonte, $query_existencia_stock)) {
            throw new Exception(mysqli_error($horizonte));
        }

        if (mysqli_num_rows($resultado_existencia_stock) == 0) {
            // Hacemos el registro del nuevo stock

            // Consultamos el stock de origen para poder crear el nuevo stock con cierta información parecida
            $query_stock_origen = "SELECT *
                                   FROM stock_has_bach shb
                                   LEFT JOIN stock s ON shb.id_stock = s.id
                                   WHERE shb.id_Producto = {$transferencia_temporal['id_producto']} AND Lote = '{$transferencia_temporal['lote']}' AND s.id_su = {$transferencia_temporal['id_sucursal_origen']}";

            if (!$resultado_stock_origen = mysqli_query($horizonte, $query_stock_origen)) {
                throw new Exception(mysqli_error($horizonte));
            }

            $stock = mysqli_fetch_all($resultado_stock_origen, MYSQLI_ASSOC)[0];

            // Insertamos el nuevo stock
            $fecha = date("Y-m-d H:i:s");
            $referencia_compra = implode("", explode("-", $fecha)) . "-1";
            $query_nuevo_stock = "INSERT INTO stock_has_bach(referencia_compra, id_stock, Lote, fecha_expiracion, id_Producto, costo_unitario, cantidad, estatus, existencias, contador, usuario_registro, fecha_update, fecha_registro)
                                  VALUES('{$referencia_compra}', {$transferencia_temporal['id_sucursal_destino']}, '{$stock['Lote']}', '{$stock['fecha_expiracion']}', {$stock['id_Producto']}, {$stock['costo_unitario']}, {$transferencia_temporal['cantidad_transferir']}, 9, {$transferencia_temporal['cantidad_transferir']}, 1, {$id_usuario}, '{$fecha}', '{$fecha}')";

            if (!$resultado_nuevo_stock = mysqli_query($horizonte, $query_nuevo_stock)) {
                throw new Exception(mysqli_error($horizonte));
            }
        } else {
            //Actualizamos la existencia del stock existente
            $query_suma_stock = "UPDATE stock_has_bach shb
                                 LEFT JOIN stock s ON shb.id_stock = s.id
                                 SET existencias = existencias + {$transferencia_temporal['cantidad_transferir']}, fecha_update = NOW(), contador = contador + 1, cantidad = {$transferencia_temporal['cantidad_transferir']}
                                 WHERE shb.id_Producto = {$transferencia_temporal['id_producto']} AND Lote = '{$transferencia_temporal['lote']}' AND s.id_su = {$transferencia_temporal['id_sucursal_destino']}";

            if (!$resultado_query_suma = mysqli_query($horizonte, $query_suma_stock)) {
                throw new Exception(mysqli_error($horizonte));
            }

            $fecha = date("Y-m-d H:i:s");
            $referencia_compra = implode("", explode("-", $fecha));
            //Actualizamos la existencia del stock existente
            $query_suma_stock = "UPDATE stock_has_bach shb
                                 LEFT JOIN stock s ON shb.id_stock = s.id
                                 SET referencia_compra = CONCAT('{$referencia_compra}', '-' ,contador)
                                 WHERE shb.id_Producto = {$transferencia_temporal['id_producto']} AND Lote = '{$transferencia_temporal['lote']}' AND s.id_su = {$transferencia_temporal['id_sucursal_destino']}";

            if (!$resultado_query_suma = mysqli_query($horizonte, $query_suma_stock)) {
                throw new Exception(mysqli_error($horizonte));
            }
        }
    }

    echo json_encode(['success' => "Traspasos realizados correctamente."]);

    mysqli_close($horizonte);
} catch (\Exception $ex) {
    echo json_encode(['error' => $ex->getMessage()]);
}

die();
