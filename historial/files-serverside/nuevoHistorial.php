<?php

require("../../Connections/horizonte2.php");

// Verificamos que la petición se haya hecho correctamente.
if (empty($_POST) || empty($_POST['id_temporal_estudios']) || empty($_POST['tipo_estudio'])) {
    echo json_encode(['error' => 'Ocurrió un error con la petición.']);
    die();
}

try {
    // Obtenemos el id temporal que identifica a los estudios y el tipo de estudio
    $id_temp = htmlspecialchars($_POST['id_temporal_estudios'], ENT_QUOTES, "utf-8", true);
    $tipo_estudio = intval(htmlspecialchars($_POST['tipo_estudio'], ENT_QUOTES, "utf-8", true));

    // Obtenemos el id del usuario que creó los estudios
    $sql = "SELECT u.id_u AS id_usuario, vc.id_vc AS id_estudio
            FROM conceptos c
            LEFT JOIN venta_conceptos vc ON c.id_to = vc.id_concepto_es
            LEFT JOIN usuarios u ON vc.id_usuario_vc = u.id_u
            WHERE c.id_tipo_concepto_to = ? AND vc.no_temp_vc = ?";
    $consulta = $horizonte->prepare($sql);
    $consulta->bind_param("is", $tipo_estudio, $id_temp);
    if (!$consulta->execute()) {
        throw new Exception($consulta->error);
    }
    $estudios = $consulta->get_result();

    // Creamos el historial para cada estudio
    while ($estudio = $estudios->fetch_object()) {
        $fecha_hora = date("Y-m-d H:i:s");
        $estatus = 1;

        $sql = "INSERT INTO historial_estudios(id_usuario, id_estudio, fecha_hora, id_estatus) VALUES(?, ?, ?, ?)";
        $consulta = $horizonte->prepare($sql);
        $consulta->bind_param("iisi", $estudio->id_usuario, $estudio->id_estudio, $fecha_hora, $estatus);
        if (!$consulta->execute()) {
            throw new Exception($consulta->error);
        }
    }
} catch (\Exception $ex) {
    echo json_encode(['error' => $ex->getMessage()]);
    die();
}

echo json_encode([true]);
die();
