<?php

include_once("../../Connections/horizonte2.php");
if (empty($_POST) || empty($_POST['id_paciente'])) {
    echo json_encode(['error' => "Ocurrió un error en la petición."]);
    die();
}

try {
    $id_paciente = intval(htmlspecialchars($_POST['id_paciente'], ENT_QUOTES, "utf-8", true));
    $sql = "SELECT id_paciente_facturable FROM pacientes_facturables pc LEFT JOIN pacientes p ON pc.id_paciente = p.id_p WHERE p.id_p = ?";
    $consulta = $horizonte->prepare($sql);
    $consulta->bind_param("i", $id_paciente);
    if (!$consulta->execute()) {
        throw new Error($consulta->error);
    }
    $ids_clientes_facturables = $consulta->get_result()->fetch_all(MYSQLI_ASSOC);

    $clientes = [];
    foreach ($ids_clientes_facturables as $id_cliente_facturable) {
        $sql = "SELECT id_p, nombre_completo_p FROM pacientes WHERE id_p = ?";
        $consulta = $horizonte->prepare($sql);
        $consulta->bind_param("i", $id_cliente_facturable['id_paciente_facturable']);
        if (!$consulta->execute()) {
            throw new Error($consulta->error);
        }
        array_push($clientes, $consulta->get_result()->fetch_object());
    }
} catch (\Error $e) {
    echo json_encode(['error' => $e->getMessage()]);
    die();
}

echo json_encode(['clientes' => $clientes]);
die();
