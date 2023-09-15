<?php

require("../../../Connections/horizonte2.php");

// Verificamos que la petición se haya hecho de manera correcta
if (!isset($_GET) || !isset($_GET['id']) || !isset($_GET['atributo'])) {
    echo json_encode(['ERROR' => 'No se pudo realizar la solicitud.']);
    die();
}

try {
    // Obtenemos el id del medicamento del cual se quiere obtener el atributo
    $id = intval(htmlspecialchars($_GET['id'], ENT_QUOTES, "utf-8", true));
    $atributo = htmlspecialchars($_GET['atributo'], ENT_QUOTES, "utf-8", true);

    // Preparamos la consulta
    $consulta = $horizonte->prepare("SELECT {$atributo} AS atributo FROM conceptos WHERE id_to = ?");
    $consulta->bind_param("i", $id);
    $consulta->bind_result($atributo);

    // Ejecutamos la consulta y verificamos si ocurrió un error
    if (!$consulta->execute()) {
        throw new Error($consulta->error);
    }

    $consulta->fetch();
} catch (\Exception $ex) {
    echo json_encode(['ERROR' => $ex->getMessage()]);
    die();
}

echo json_encode(['ATRIBUTO' => $atributo]);
die();

$horizonte->close();
