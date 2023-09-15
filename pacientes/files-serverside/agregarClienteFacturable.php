<?php

include_once("../../Connections/horizonte2.php");

if (empty($_POST) || empty($_POST['id_paciente']) || empty($_POST['id_pacientes_facturables'])) {
    echo json_encode(['error' => "Ocurrió un error con la petición."]);
    die();
}

try {
    $id_paciente = intval(htmlspecialchars($_POST['id_paciente'], ENT_QUOTES, "utf-8", true));
    $ids_pacientes_facturables = json_decode($_POST['id_pacientes_facturables']);
    if (count($ids_pacientes_facturables) == 0) {
        throw new Exception("Debes seleccionar al menos a un cliente para facturar.");
    }

    for ($i = 0; $i < count($ids_pacientes_facturables); $i++) { 
        $sql = "INSERT INTO pacientes_facturables(id_paciente, id_paciente_facturable) VALUES(?, ?)";
        $consulta = $horizonte->prepare($sql);
        $consulta->bind_param("ii", $id_paciente, $ids_pacientes_facturables[$i]);
        if (!$consulta->execute()) {
            throw new Exception($consulta->error);
        }
    }
} catch (\Exception $ex) {
    echo json_encode(['error' => $ex->getMessage()]);
    die();
}

echo json_encode(['exito' => "Clientes agregados correctamente."]);
die();
