<?php

include_once("../../Connections/horizonte2.php");

try {
    $sql = "SELECT * FROM uso_cfdi";
    $consulta = $horizonte->prepare($sql);
    if (!$consulta->execute()) {
        throw new Error($consulta->error);
    }
    $usos = $consulta->get_result()->fetch_all(MYSQLI_ASSOC);
} catch (\Error $e) {
    echo json_encode(['error' => $e->getMessage()]);
    die();
}

echo json_encode(['usos' => $usos]);
die();
