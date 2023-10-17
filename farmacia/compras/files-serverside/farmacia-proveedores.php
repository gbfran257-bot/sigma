<?php

try {
    require("../../../Connections/horizonte2.php");

    $query_proveedores = "SELECT MD5(id_p) AS id_p, nombre_completo_p AS cliente FROM pacientes WHERE proveedor = 1";

    if (!$resultado_query_proveedores = mysqli_query($horizonte, $query_proveedores)) {
        throw new Exception(mysqli_error($horizonte));
    }

    $provedores = [];
    array_push($provedores, '<option value="" selected>Seleccione el proveedor de compra</option>');

    while ($proveedor = mysqli_fetch_assoc($resultado_query_proveedores)) {
        array_push($provedores, "<option value='{$proveedor['id_p']}'>{$proveedor['cliente']}</option>");
    }

    echo json_encode($provedores);
} catch (\Exception $ex) {
    echo json_encode(['error' => $ex->getMessage()]);
}

die();
