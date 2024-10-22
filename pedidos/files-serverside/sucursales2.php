<?php

try {
    require("../../Connections/horizonte2.php");

    $query_sucursales = "";

    // Comprobamos si se quiere filtrar por nombre de la sucursal
    if (isset($_GET['term']) && !empty($_GET['term'])) {
        $nombre_su = "%" . htmlentities($_GET['term'], ENT_QUOTES, "utf-8") . "%";
        $query_sucursales = "SELECT id AS id, clave_su AS nombre FROM stock WHERE nombre_su LIKE \"{$nombre_su}\"";
    } else {
        $query_sucursales = "SELECT id AS id, clave_su AS nombre FROM stock";
    }
    
    $resultado_query_sucursales = mysqli_query($horizonte, $query_sucursales);

    $sucursales = [];
    $sucursales["results"] = [];
    while ($resultado_sucursal = mysqli_fetch_assoc($resultado_query_sucursales)) {
        $sucursal = ["id" => $resultado_sucursal['id'], "text" => $resultado_sucursal['nombre']];
        $sucursales['results'][] = $sucursal;
    }

    echo json_encode($sucursales);
} catch (\Exception $ex) {
    echo json_encode(['error' => $ex->getMessage()]);
}

die();
