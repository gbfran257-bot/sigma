<?php

require_once("../../../Connections/horizonte2.php");

if (empty($_GET) || empty($_GET['id_p'])) {
    echo json_encode(['error' => 'Ocurrió un error con la petición.']);
    die();
}

try {
    $id_paciente = intval(htmlspecialchars($_GET['id_p'], ENT_QUOTES, "utf-8", true));

    $sql = "SELECT * FROM pacientes WHERE id_p = ?";
    $consulta = $horizonte->prepare($sql);
    $consulta->bind_param("i", $id_paciente);

    if (!$consulta->execute()) {
        throw new Exception($consulta->error);
    }

    $datosPaciente = $consulta->get_result()->fetch_object();
} catch (\Exception $ex) {
    echo json_encode(['error' => $ex->getMessage()]);
    die();
}

echo json_encode($datosPaciente);
die();
