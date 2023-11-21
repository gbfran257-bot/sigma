<?php

try {
    $fecha = date("Y-m-d");

    require("../../../Connections/horizonte2.php");

    $query_contador_transferencia_hoy = "SELECT COUNT(*) FROM transferencia_temporal WHERE DATE_FORMAT(fecha_transferencia, \"%Y-%m-%d\") = \"{$fecha}\" GROUP BY id_temporal";
    if (!$resultado_query = mysqli_query($horizonte, $query_contador_transferencia_hoy)) {
        throw new Exception(mysqli_error($horizonte));
    }

    $contador = intval(mysqli_num_rows($resultado_query)) + 1;
    $nuevo_id_temporal = $fecha . "-" . $contador;
    echo json_encode(['id_temporal' => $nuevo_id_temporal]);
} catch (\Exception $ex) {
    echo json_encode(['error' => $ex->getMessage()]);
}

die();
