<?php

try {
    $id_cama = intval(htmlentities($_POST['id_cama']));
    $identificador = intval(htmlentities($_POST['no_ca']));
    $area = intval(htmlentities($_POST['area_ca']));
    $ubicacion = htmlentities($_POST['ubicacion_ca']);
    $descripcion = htmlentities($_POST['descripcion_ca']);

    $query = "UPDATE camas SET no_ca = {$identificador}, area_ca = {$area}, ubicacion_ca = '{$ubicacion}', descripcion_ca = '{$descripcion}' WHERE id_ca = {$id_cama}";

    require("../../../Connections/horizonte2.php");

    if (!mysqli_query($horizonte, $query)) {
        throw new Exception(mysqli_error($horizonte));
    }

    echo json_encode(['success' => "Cama actualizada correctamente."]);
} catch (\Exception $ex) {
    echo json_encode(['error' => $ex->getMessage()]);
}

die();
