<?php

try {
    $id_cama = intval(htmlentities($_GET['idc']));

    $query = "SELECT id_ca, area_ca, CONCAT('[', clave_a , ']', ' ', nombre_a) AS area, ubicacion_ca, no_ca, descripcion_ca FROM camas LEFT JOIN areas ON camas.area_ca = areas.id_a WHERE id_ca = {$id_cama}";

    require("../../../Connections/horizonte2.php");

    if (!$resultado_query = mysqli_query($horizonte, $query)) {
        throw new Exception(mysqli_error($horizonte));
    }

    echo json_encode(['success' => mysqli_fetch_object($resultado_query)]);
} catch (\Exception $ex) {
    echo json_encode(['error' => $ex->getMessage()]);
}

die();
