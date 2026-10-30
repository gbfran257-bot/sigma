<?php

include_once("../../Connections/horizonte2.php");

if (empty($_POST) || empty($_POST['id_paciente']) || empty($_POST['id_cliente_facturable'])) {
    echo "Ocurrió un error con la petición.";
    die();
}

try {
    $id_paciente = intval(htmlspecialchars($_POST['id_paciente'], ENT_QUOTES, "utf-8", true));
    $id_cliente_facturable = intval(htmlspecialchars($_POST['id_cliente_facturable'], ENT_QUOTES, "utf-8", true));

    $sql = "DELETE FROM pacientes_facturables WHERE id_paciente = ? AND id_paciente_facturable = ?";
    $consulta = $horizonte->prepare($sql);
    $consulta->bind_param("ii", $id_paciente, $id_cliente_facturable);
    if (!$consulta->execute()) {
        throw new Exception($consulta->error);
    }

    $horizonte->close();
} catch (\Exception $ex) {
    echo $ex->getMessage();
    die();
}

echo "Cliente eliminado correctamente.";
die();
