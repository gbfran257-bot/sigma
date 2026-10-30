<?php

require("../../Connections/horizonte2.php");

// Verificamos que la petición se haya hecho de manera correcta
if (empty($_POST) || empty($_POST['id_usuario']) || empty($_POST['id_estudio']) || empty($_POST['estatus'])) {
    echo json_encode(['error' => 'Ocurrió un error con la petición.']);
    die();
}

try {
    // Obtenemos los parametros de la petición
    $id_usuario = intval(htmlspecialchars($_POST['id_usuario'], ENT_QUOTES, "utf-8", true));
    $id_estudio = intval(htmlspecialchars($_POST['id_estudio'], ENT_QUOTES, "utf-8", true));
    $estatus = intval(htmlspecialchars($_POST['estatus'], ENT_QUOTES, "utf-8", true));

    // Preparamos la consulta para obtener el nombre del usuario, y la fecha y hora del historial
    $fecha_hora = date("Y-m-d H:i:s");

    $sql = "INSERT INTO historial_estudios(id_usuario, id_estudio, fecha_hora, id_estatus) VALUES(?, ?, ?, ?)";
    $consulta = $horizonte->prepare($sql);
    $consulta->bind_param("iisi", $id_usuario, $id_estudio, $fecha_hora, $estatus);
    if (!$consulta->execute()) {
        throw new Exception($consulta->error);
    }
} catch (\Exception $ex) {
    echo json_encode(['error' => $ex->getMessage()]);
    die();
}

$horizonte->close();

echo json_encode([true]);
die();
