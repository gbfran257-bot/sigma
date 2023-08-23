<?php

require("../../Connections/horizonte2.php");

// Verificamos que la petición se haya hecho de manera correcta
if (empty($_GET) || (empty($_GET['referencia_ov']))) {
    echo json_encode(['error' => 'Ocurrió un error con la petición.']);
    die();
}

try {
    // Obtenemos el parametro que se haya pasado en la url
    $referencia = htmlspecialchars($_GET['referencia_ov'], ENT_QUOTES, "utf-8", true);

    # Obtenemos el id de la venta para obtener le historial
    $sql = "SELECT id_vc AS id_estudio, concepto_to AS estudio
            FROM venta_conceptos vc
            LEFT JOIN orden_venta ov ON ov.referencia_ov = vc.referencia_vc
            LEFT JOIN conceptos c ON vc.id_concepto_es = c.id_to
            WHERE ov.referencia_ov = ? AND c.id_tipo_concepto_to BETWEEN 3 AND 4";
    $consulta = $horizonte->prepare($sql);
    $consulta->bind_param("s", $referencia);
    if (!$consulta->execute()) {
        throw new Exception($consulta->error);
    }
    $resultados_estudios = $consulta->get_result();

    # Obtenemos el historial de cada estudios obtenido anteriormente
    $estudios = [];
    while ($estudio = $resultados_estudios->fetch_object()) {
        $sql = "SELECT
            estatus,
            nombre_u AS usuario,
            DATE_FORMAT(fecha_hora, '%d/%m/%Y') AS fecha,
            DATE_FORMAT(fecha_hora, '%H:%i:%s') AS hora
            FROM historial_estudios he
            LEFT JOIN usuarios u ON he.id_usuario = u.id_u
            LEFT JOIN estatus_estudio ee ON he.id_estatus = ee.id
            WHERE id_estudio = ?
            ORDER BY fecha_hora";
        $consulta = $horizonte->prepare($sql);
        $consulta->bind_param("s", $estudio->id_estudio);
        if (!$consulta->execute()) {
            throw new Exception($consulta->error);
        }
        $estudio->historial = $consulta->get_result()->fetch_all(MYSQLI_ASSOC);
        array_push($estudios, $estudio);
    }
} catch (\Exception $ex) {
    echo json_encode(["error" => $ex->getMessage()]);
    die();
}

echo json_encode(["estudios" => $estudios]);
die();
