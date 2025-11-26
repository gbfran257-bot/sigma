<?php

try {
    $id_temporal = $_POST['id_temporal'];

    require("../../../Connections/horizonte2.php");

    $query_transferencias_temporales = "SELECT * FROM transferencia_temporal WHERE id_temporal = '{$id_temporal}'";

    if (!$resultado_query_transferencias = mysqli_query($horizonte, $query_transferencias_temporales)) {
        throw new Exception(mysqli_error($horizonte));
    }

    $contador = 0;

    while ($transferencia_temporal = mysqli_fetch_assoc($resultado_query_transferencias)) {
        $qryVerifExist = "SELECT COUNT(*) FROM stock_has_bach WHERE id = {$transferencia_temporal['id_stock_has_bach']} AND existencias >= {$transferencia_temporal['cantidad_transferir']}";
        $resVerifExist = mysqli_query($horizonte, $qryVerifExist) or die (mysqli_error($horizonte));
        $rowVerifExist = mysqli_fetch_row($resVerifExist);
        if ($rowVerifExist[0] == 0) {
            $contador++;
        }
    }

    echo $contador;

    mysqli_close($horizonte);
} catch (\Exception $ex) {
    echo json_encode(['error' => $ex->getMessage()]);
}

die();

