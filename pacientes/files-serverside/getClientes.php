<?php

include_once("../../Connections/horizonte2.php");

try {
    $sql = "SELECT id_p, nombre_completo_p FROM pacientes WHERE facturar = ?";
    $facturar = 1;
    $consulta = $horizonte->prepare($sql);
    $consulta->bind_param("i", $facturar);
    if (!$consulta->execute()) {
        throw new Error($consulta->error);
    }
    $clientes = $consulta->get_result()->fetch_all(MYSQLI_ASSOC);
} catch (\Error $e) {
    echo json_encode(['error' => $e->getMessage()]);
    die();
}

echo json_encode(['clientes' => $clientes]);
die();
