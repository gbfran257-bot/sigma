<?php

require("../../../Connections/horizonte2.php");

// Verificamos que la petición se haya realiado de manera correcta
if (!isset($_GET) || !isset($_GET['id'])) {
    echo json_encode(['ERROR' => 'No se pudo realizar la solicitud.']);
    die();
}

try {
    // Obtenemos el id del medicamento del cual se quieren obtener sus antagonismos
    $idMedicamento = intval(htmlspecialchars($_GET['id'], ENT_QUOTES, "utf-8", true));

    // Primero obtenemos el id de los medicamentos referenciados como antagonismos
    $consulta = $horizonte->prepare("SELECT a.id_medicamento FROM antagonismo a LEFT JOIN medicamento_antagonismo ma ON a.id = ma.id_antagonismo WHERE ma.id_medicamento = ?");
    $consulta->bind_param("i", $idMedicamento);
    
    if (!$consulta->execute()) {
        throw new Error($consulta->error);
    }

    $idsAntagonismos = $consulta->get_result();

    // Una vez obtenemos los ids de los medicamentos antagonistas, obtenemos el nombre de cada uno
    $antagonismos = [];
    while ($idAntagonismo = $idsAntagonismos->fetch_object()->id_medicamento) {
        $consulta = $horizonte->prepare("SELECT c.concepto_to as medicamento FROM conceptos c LEFT JOIN medicamento_antagonismo ma ON c.id_to = ma.id_medicamento WHERE c.id_to = ?");
        $consulta->bind_param("i", $idAntagonismo);

        if (!$consulta->execute()) {
            throw new Error($consulta->error);
        }

        array_push($antagonismos, $consulta->get_result()->fetch_object()->medicamento);
    }
} catch (\Exception $ex) {
    echo json_encode(['ERROR' => $ex->getMessage()]);
    die();
}

// Devolvemos los nombres de los medicamentos antagonistas del medicamento que se quiere agregar
echo json_encode(['ANTAGONISMOS' => $antagonismos]);
die();

$horizonte->close();
