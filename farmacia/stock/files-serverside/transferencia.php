<?php

try {
    $id_transferencia_temporal = $_POST['id_t_t'];
    $id_usuario = intval($_POST['id_u']);
    //$existencias_producto = intval($_POST['existencias_producto']);

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
                              WHERE shb.id_Producto = {$transferencia_temporal['id_producto']} AND Lote = '{$transferencia_temporal['lote']}' AND s.id_su = {$transferencia_temporal['id_sucursal_origen']} AND shb.id = {$transferencia_temporal['id_stock_has_bach']}";
                              //echo $query_resta_stock;
        if (!$resultado_query_resta_stock = mysqli_query($horizonte, $query_resta_stock)) {
            throw new Exception(mysqli_error($horizonte));
        }

        /* -- Sumamos la cantidad a transferir a la existencia del stock correspondiente al producto seleccionado (destino)
        $query_existencia_stock = "SELECT *
                                   FROM stock_has_bach shb
                                   LEFT JOIN stock s ON shb.id_stock = s.id
                                   WHERE shb.id_Producto = {$transferencia_temporal['id_producto']} AND shb.Lote = '{$transferencia_temporal['lote']}' AND s.id_su = {$transferencia_temporal['id_sucursal_destino']} AND fecha_expiracion = '{$transferencia_temporal['caducidad']}' ORDER BY existencias DESC LIMIT 1";
        if (!$resultado_existencia_stock = mysqli_query($horizonte, $query_existencia_stock)) {
            throw new Exception(mysqli_error($horizonte));
        } */

        /*Hacemos el registro del nuevo stock*/

        // Consultamos el stock de origen para poder crear el nuevo stock con cierta información parecida
        $query_stock_origen = "SELECT *
                                FROM stock_has_bach shb
                                WHERE shb.id = {$transferencia_temporal['id_stock_has_bach']}";

        if (!$resultado_stock_origen = mysqli_query($horizonte, $query_stock_origen)) {
            throw new Exception(mysqli_error($horizonte));
        }

        $stock = mysqli_fetch_all($resultado_stock_origen, MYSQLI_ASSOC)[0];

        //Ajustamos el id del stock antes de transferir
        $query_id_stock = "SELECT id AS id_stock FROM stock WHERE id_su = {$transferencia_temporal['id_sucursal_destino']} LIMIT 1";
        $resultado_query_id_s = mysqli_query($horizonte, $query_id_stock);
        $id_stock = mysqli_fetch_object($resultado_query_id_s)->id_stock;

        // Insertamos el nuevo stock
        $fecha = date("Y-m-d H:i:s");
        $query_nuevo_stock = "INSERT INTO stock_has_bach(referencia_compra, id_stock, Lote, fecha_expiracion, id_Producto, costo_unitario, cantidad, estatus, existencias, contador, usuario_registro, fecha_update, fecha_registro, es_traspaso, referencia_traspaso_temporal, id_proveedor)
                                VALUES('{$stock['referencia_compra']}', $id_stock, '{$stock['Lote']}', '{$stock['fecha_expiracion']}', {$stock['id_Producto']}, {$stock['costo_unitario']}, {$transferencia_temporal['cantidad_transferir']}, 9, {$transferencia_temporal['cantidad_transferir']}, 1, {$id_usuario}, '{$fecha}', '{$fecha}', 1, '{$id_transferencia_temporal}', '{$stock['id_proveedor']}')";

        if (!$resultado_nuevo_stock = mysqli_query($horizonte, $query_nuevo_stock)) {
            throw new Exception(mysqli_error($horizonte));
        }

        /* if (mysqli_num_rows($resultado_existencia_stock) == 0) {
           -- Hacemos el registro del nuevo stock

           -- Consultamos el stock de origen para poder crear el nuevo stock con cierta información parecida
            $query_stock_origen = "SELECT *
                                   FROM stock_has_bach shb
                                   LEFT JOIN stock s ON shb.id_stock = s.id
                                   WHERE shb.id_Producto = {$transferencia_temporal['id_producto']} AND shb.Lote = '{$transferencia_temporal['lote']}' AND s.id_su = {$transferencia_temporal['id_sucursal_origen']} AND shb.id = {$transferencia_temporal['id_stock_has_bach']}";

            if (!$resultado_stock_origen = mysqli_query($horizonte, $query_stock_origen)) {
                throw new Exception(mysqli_error($horizonte));
            }

            $stock = mysqli_fetch_all($resultado_stock_origen, MYSQLI_ASSOC)[0];

           --Ajustamos el id del stock antes de transferir
            $query_id_stock = "SELECT id AS id_stock FROM stock WHERE id_su = {$transferencia_temporal['id_sucursal_destino']} LIMIT 1";
            $resultado_query_id_s = mysqli_query($horizonte, $query_id_stock);
            $id_stock = mysqli_fetch_object($resultado_query_id_s)->id_stock;

           -- Insertamos el nuevo stock
            $fecha = date("Y-m-d H:i:s");
            $query_nuevo_stock = "INSERT INTO stock_has_bach(referencia_compra, id_stock, Lote, fecha_expiracion, id_Producto, costo_unitario, cantidad, estatus, existencias, contador, usuario_registro, fecha_update, fecha_registro, es_traspaso, referencia_traspaso_temporal, id_proveedor)
                                  VALUES('{$stock['referencia_compra']}', $id_stock, '{$stock['Lote']}', '{$stock['fecha_expiracion']}', {$stock['id_Producto']}, {$stock['costo_unitario']}, {$transferencia_temporal['cantidad_transferir']}, 9, {$transferencia_temporal['cantidad_transferir']}, 1, {$id_usuario}, '{$fecha}', '{$fecha}', 1, '{$id_transferencia_temporal}', '{$stock['id_proveedor']}')";

            if (!$resultado_nuevo_stock = mysqli_query($horizonte, $query_nuevo_stock)) {
                throw new Exception(mysqli_error($horizonte));
            }
        } else {
            --obtenemos el id de stock_has_bach a donde vamos a transferir
            $query_id_shb = "SELECT shb.id AS id_shb
                                   FROM stock_has_bach shb
                                   LEFT JOIN stock s ON shb.id_stock = s.id
                                   WHERE shb.id_Producto = {$transferencia_temporal['id_producto']} AND shb.Lote = '{$transferencia_temporal['lote']}' AND s.id_su = {$transferencia_temporal['id_sucursal_destino']} AND fecha_expiracion = '{$transferencia_temporal['caducidad']}' ORDER BY existencias DESC LIMIT 1";

            if (!$resultado_id_shb = mysqli_query($horizonte, $query_id_shb)) {
                throw new Exception(mysqli_error($horizonte));
            }

            $id_shb = mysqli_fetch_all($resultado_id_shb, MYSQLI_ASSOC)[0];
            --Actualizamos la existencia del stock existente
            $query_suma_stock = "UPDATE stock_has_bach shb
                                 LEFT JOIN stock s ON shb.id_stock = s.id
                                 SET existencias = existencias + {$transferencia_temporal['cantidad_transferir']}, fecha_update = NOW(), contador = contador + 1, cantidad = {$transferencia_temporal['cantidad_transferir']}, es_traspaso = 1
                                 WHERE shb.id_Producto = {$transferencia_temporal['id_producto']} AND shb.Lote = '{$transferencia_temporal['lote']}' AND s.id_su = {$transferencia_temporal['id_sucursal_destino']} AND shb.id = {$id_shb['id_shb']}";

            if (!$resultado_query_suma = mysqli_query($horizonte, $query_suma_stock)) {
                throw new Exception(mysqli_error($horizonte));
            }

            $fecha = date("Y-m-d");
            $referencia_compra = implode("", explode("-", $fecha));
            --Actualizamos la existencia del stock existente
            $query_suma_stock = "UPDATE stock_has_bach shb
                                 LEFT JOIN stock s ON shb.id_stock = s.id
                                 SET referencia_compra = CONCAT('{$referencia_compra}', '-' ,contador)
                                 WHERE shb.id_Producto = {$transferencia_temporal['id_producto']} AND shb.Lote = '{$transferencia_temporal['lote']}' AND s.id_su = {$transferencia_temporal['id_sucursal_destino']} AND shb.id = {$id_shb['id_shb']}";

            if (!$resultado_query_suma = mysqli_query($horizonte, $query_suma_stock)) {
                throw new Exception(mysqli_error($horizonte));
            }
        } */
    }

    echo json_encode(['success' => "Traspasos realizados correctamente."]);

    mysqli_close($horizonte);
} catch (\Exception $ex) {
    echo json_encode(['error' => $ex->getMessage()]);
}

die();
