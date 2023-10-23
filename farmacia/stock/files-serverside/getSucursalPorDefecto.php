<?php

try {
    require("../../../Connections/horizonte2.php");

    $id_sucursal = intval(htmlspecialchars($_GET['id_s'], ENT_QUOTES, "utf-8"));

    $query_sucursal = "SELECT nombre_su AS nombre FROM sucursales WHERE id_su = {$id_sucursal}";

    if (!$resultado_query_sucursal = mysqli_query($horizonte, $query_sucursal)) {
        throw new Exception(mysqli_error($horizonte));
    }

    echo json_encode(mysqli_fetch_object($resultado_query_sucursal));
} catch (\Exception $ex) {
    echo json_encode(['error' => $ex->getMessage()]);
}

die();
