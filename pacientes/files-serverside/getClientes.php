<?php

include_once("../../Connections/horizonte2.php");

if (empty($_GET) || empty($_GET['id_paciente']) || empty($_GET['clientes_seleccionados'])) {
    echo json_encode(['error' => "Ocurrió un error con la petición."]);
    die();
}

try {
    $id_paciente = intval(htmlspecialchars($_GET['id_paciente'], ENT_QUOTES, "utf-8", true));
    $clientesSeleccionados = json_decode(($_GET['clientes_seleccionados']));

    $sql = "SELECT id_p, nombre_completo_p FROM pacientes WHERE facturar = ?";
    $facturar = 1;
    $consulta = $horizonte->prepare($sql);
    $consulta->bind_param("i", $facturar);
    if (!$consulta->execute()) {
        throw new Error($consulta->error);
    }
    $pre_clientes = $consulta->get_result()->fetch_all(MYSQLI_ASSOC);

    // Filtramos los pacientes que puede ser seleccionados, eliminamos al propio paciente y a los que ya tiene seleccionados
    $clientes = [];
    foreach ($pre_clientes as $cliente) {
        if ($cliente['id_p'] != $id_paciente && !clienteYaSeleccionado($cliente, $clientesSeleccionados)) {
            array_push($clientes, $cliente);
        }
    }
} catch (\Error $e) {
    echo json_encode(['error' => $e->getMessage()]);
    die();
}

function clienteYaSeleccionado($cliente, $clientesSeleccionados)
{
    for ($i = 0; $i < count($clientesSeleccionados); $i++) {
        if ($cliente['id_p'] == $clientesSeleccionados[$i]) {
            return true;
        }
    }
    return false;
}

echo json_encode(['clientes' => $clientes]);
die();
