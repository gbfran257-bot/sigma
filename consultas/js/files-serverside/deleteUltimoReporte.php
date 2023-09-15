<?php

require("../../../Connections/horizonte2.php");

try {
    // 1. Obtenemos el id del último reporte registrado
    // Preparamos la consulta
    $consulta = "SELECT MAX(id) AS id FROM reporte_consulta_antagonismo";
    $consulta_preparada = $horizonte->prepare($consulta);

    // Ejecutamos la consulta
    if (!$consulta_preparada->execute()) {
        throw new Exception();
    }
    $id_ultimo_registro = $consulta_preparada->get_result()->fetch_object()->id;

    // 2. Eliminamos el último reporte registrado
    // Preparamos la consulta
    $consulta = "DELETE FROM reporte_consulta_antagonismo WHERE id = ?";
    $consulta_preparada = $horizonte->prepare($consulta);
    $consulta_preparada->bind_param("i", $id_ultimo_registro);

    // Ejecutamos la consulta preparada
    echo $consulta_preparada->execute();
} catch (\Exception $ex) {
    echo false;
}

$horizonte->close();
