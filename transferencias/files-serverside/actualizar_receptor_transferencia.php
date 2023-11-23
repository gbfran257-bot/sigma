<?php

try {
    $folio = htmlentities($_POST['f'], ENT_QUOTES, "utf-8");
    $id_usuario = intval(htmlentities($_POST['u'], ENT_QUOTES, "utf-8"));

    require("../../Connections/horizonte2.php");

    $query_actualizar_receptor = "UPDATE transferencia_temporal SET id_usuario_receptor = {$id_usuario} WHERE id_transferencia = '{$folio}'";
    $resultado_quer = mysqli_query($horizonte, $query_actualizar_receptor);

    echo json_encode(['success' => "Receptor asignado correctamente."]);
} catch (\Exception $ex) {
    echo json_encode(['error' => $ex->getMessage()]);
}

die();
