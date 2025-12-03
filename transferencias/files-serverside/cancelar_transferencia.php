<?php

try {
    $id_temporal = $_POST['id_temporal'];
    $id_u = intval($_POST['id_u']);

    date_default_timezone_set("America/Mexico_City");
    $fecha_recepcion = date("Y-m-d H-i-s");

    require("../../Connections/horizonte2.php");

    $query_actualizar_receptor = "UPDATE transferencia_temporal SET transf_valida = 0 WHERE id_temporal = '{$id_temporal}' AND transf_valida = 1 AND id_usuario_receptor = 0";
    if (!mysqli_query($horizonte, $query_actualizar_receptor)) {
        throw new Exception(mysqli_error($horizonte));
    }

    echo json_encode(['success' => "Transferencia cancelada."]);

    mysqli_close($horizonte);
} catch (\Exception $ex) {
    echo json_encode(['error' => $ex->getMessage()]);
}

die();
