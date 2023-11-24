<?php

try {
    $folio = htmlentities($_POST['f'], ENT_QUOTES, "utf-8");
    $id_usuario = intval(htmlentities($_POST['u'], ENT_QUOTES, "utf-8"));

    require("../../Connections/horizonte2.php");

    $query_actualizar_receptor = "UPDATE transferencia_temporal SET id_usuario_receptor = {$id_usuario} WHERE id_transferencia = '{$folio}'";
    if (!mysqli_query($horizonte, $query_actualizar_receptor)) {
        throw new Exception(mysqli_error($horizonte));
    }

    $query_usuario = "SELECT usuario_u FROM usuarios WHERE id_u = {$id_usuario}";
    if (!$resultado_query_usuario = mysqli_query($horizonte, $query_usuario)) {
        throw new Exception(mysqli_error($horizonte));
    }
    $usuario = mysqli_fetch_object($resultado_query_usuario)->usuario_u;

    echo json_encode(['success' => $usuario]);

    mysqli_close($horizonte);
} catch (\Exception $ex) {
    echo json_encode(['error' => $ex->getMessage()]);
}

die();
