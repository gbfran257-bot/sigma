<?php

try {
    $id = intval(htmlentities($_POST['no_ca']));
    $area = intval(htmlentities($_POST['area_ca']));
    $ubicacion = htmlentities($_POST['ubicacion_ca']);
    $descripcion = htmlentities($_POST['descripcion_ca']);

    $query = "UPDATE camas SET area_ca = {$area}, ubicacion_ca = '{$ubicacion}', descripcion_ca = '{$descripcion}' WHERE no_ca = {$id}";

    require("../../../Connections/horizonte2.php");

    mysqli_query($horizonte, $query);

    echo json_encode(['success' => "Cama actualizada correctamente."]);
} catch (\Exception $ex) {
    echo json_encode(['error' => $ex->getMessage()]);
}

die();
