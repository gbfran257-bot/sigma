<?php

try {
    $id_temporal = "\"" . $_POST['id_temporal'] . "\"";

    require("../../../Connections/horizonte2.php");

    $query_eliminar_transferencia_temporal = "DELETE FROM transferencia_temporal WHERE id_temporal = {$id_temporal}";

    $resultado_query = mysqli_query($horizonte, $query_eliminar_transferencia_temporal);

    echo json_encode(["success" => "Orden cancelada correctamente."]);
} catch (\Exception $ex) {
    echo json_encode(['error' => $ex->getMessage()]);
}

die();
