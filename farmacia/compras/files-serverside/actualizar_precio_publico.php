<?php

try {
    $id_producto = intval(htmlentities($_POST['id_producto']));
    $nuevo_precio = doubleval(htmlentities($_POST['nuevo_precio']));

    require("../../../Connections/horizonte2.php");

    $query_update = "UPDATE conceptos SET precio_to = {$nuevo_precio} WHERE id_to = {$id_producto}";

    if (!$resultado_query_update = mysqli_query($horizonte, $query_update)) {
        throw new Exception(mysqli_error($horizonte));
    }

    echo json_encode(['success' => "Precio actualizado correctamente."]);
} catch (\Exception $ex) {
    echo json_encode(['error' => $ex->getMessage()]);
}

die();
