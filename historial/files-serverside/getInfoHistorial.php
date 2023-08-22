<?php

require("../../Connections/horizonte2.php");

// Verificamos que la petición se haya hecho de manera correcta
if (empty($_GET) || empty($_GET['ide']) || empty($_GET['te'])) {
    echo json_encode(['error' => 'Ocurrió un error con la petición.']);
    die();
}

try {
    // Obtenemos los parametros de la petición
    $id_estudio = intval(htmlspecialchars($_GET['ide'], ENT_QUOTES, "utf-8", true));
    $tipo_estudio = intval(htmlspecialchars($_GET['te'], ENT_QUOTES, "utf-8", true));

    // Preparamos la consulta para obtener el nombre del usuario, y la fecha y hora del historial
    $sql = "SELECT nombre_u AS usuario, DATE_FORMAT(historial_estudios.fecha_hora, '%d/%m/%Y %H:%i:%s') AS fecha_hora
            FROM usuarios
            LEFT JOIN historial_estudios ON usuarios.id_u = historial_estudios.id_usuario
            WHERE id_estudio = ? AND id_estatus = ?";
    $consulta = $horizonte->prepare($sql);
    $consulta->bind_param("ii", $id_estudio, $tipo_estudio);
    if (!$consulta->execute()) {
        throw new Exception($consulta->error);
    }
    $info = $consulta->get_result()->fetch_object();
} catch (\Exception $ex) {
    echo json_encode(['error' => $ex->getMessage()]);
    die();
}

echo json_encode(['info' => $info]);
die();
