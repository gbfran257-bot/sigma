<?php

try {
    $referencia = htmlentities($_POST['referencia_compra'], ENT_QUOTES, "utf-8");

    require("../../../Connections/horizonte2.php");

    $query_eliminar_factura = "DELETE FROM compra_factura WHERE referencia_compra = '{$referencia}'";

    if (!mysqli_query($horizonte, $query_eliminar_factura)) {
        throw new Exception(mysqli_error($horizonte));
    }

    echo json_encode(['success' => "Comprobante de factura eliminado correctamente."]);
} catch (\Exception $ex) {
    echo json_encode(['error' => $ex->getMessage()]);
}

die();
