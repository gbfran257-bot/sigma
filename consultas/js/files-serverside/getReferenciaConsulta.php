<?php

require_once("../../../Connections/horizonte2.php");

if (empty($_GET) || empty($_GET['id_c'])) {
    echo json_encode(['error' => 'Ocurrió un error con la petición.']);
    die();
}

try {
    $id_consulta = intval(htmlspecialchars($_GET['id_c'], ENT_QUOTES, "utf-8", true));

    $sql = "SELECT referencia_vc AS referencia, id_usuario_vc AS id_usuario FROM venta_conceptos WHERE id_vc = ?";
    $consulta = $horizonte->prepare($sql);
    $consulta->bind_param("i", $id_consulta);

    if (!$consulta->execute()) {
        throw new Exception($consulta->error);
    }

    $datosConsulta = $consulta->get_result()->fetch_object();
} catch (\Exception $ex) {
    echo json_encode(['error' => $ex->getMessage()]);
    die();
}

echo json_encode($datosConsulta);

$horizonte->close();

die();
