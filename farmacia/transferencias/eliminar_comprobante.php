<?php

try {
    $referencia = htmlentities($_POST['referencia_compra'], ENT_QUOTES, "utf-8");

    require("../../Connections/horizonte2.php");

    $query_eliminar_factura = "DELETE FROM comprobante_transferencia WHERE referencia = '{$referencia}'";

    if (!mysqli_query($horizonte, $query_eliminar_factura)) {
        throw new Exception(mysqli_error($horizonte));
    }

    echo json_encode(['success' => "Comprobante eliminado correctamente."]);
} catch (\Exception $ex) {
    echo json_encode(['error' => $ex->getMessage()]);
}

die();