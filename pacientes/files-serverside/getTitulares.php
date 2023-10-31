<?php

try {
    require("../../Connections/horizonte2.php");

    $query_titulares = "SELECT id_p, nombre_completo_p FROM pacientes WHERE titular = 1";

    if (!$resultado_query = mysqli_query($horizonte, $query_titulares)) {
        throw new Exception(mysqli_errno($horizonte));
    }

    $titulares = [];
    array_push($titulares, "<option value='' selected>--SELECCIONAR--</option>");
    while ($titular = mysqli_fetch_assoc($resultado_query)) {
        array_push($titulares, "<option value='{$titular['id_p']}'>{$titular['nombre_completo_p']}</option>");
    }

    echo json_encode($titulares);
} catch (\Exception $ex) {
    echo json_encode(['error' => $ex->getMessage()]);
}

die();
