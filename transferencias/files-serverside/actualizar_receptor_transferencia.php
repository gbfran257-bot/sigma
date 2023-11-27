<?php

try {
    $folio = htmlentities($_POST['f'], ENT_QUOTES, "utf-8");
    $id_usuario = intval(htmlentities($_POST['u'], ENT_QUOTES, "utf-8"));

    date_default_timezone_set("America/Mexico_City");
    $fecha_recepcion = date("Y-m-d H-i-s");

    require("../../Connections/horizonte2.php");

    $query_actualizar_receptor = "UPDATE transferencia_temporal SET id_usuario_receptor = {$id_usuario}, fecha_recepcion = '{$fecha_recepcion}' WHERE id_transferencia = '{$folio}'";
    if (!mysqli_query($horizonte, $query_actualizar_receptor)) {
        throw new Exception(mysqli_error($horizonte));
    }

    echo json_encode(['success' => "Receptor registrado correctamente."]);

    mysqli_close($horizonte);
} catch (\Exception $ex) {
    echo json_encode(['error' => $ex->getMessage()]);
}

die();
