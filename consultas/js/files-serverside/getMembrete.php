<?php

require_once("../../../Connections/horizonte2.php");

# Verificamos que la consulta se haya hecho de manera correcta
if (empty($_GET) || empty($_GET['id_e']) || empty($_GET['tipo_m'])) {
    echo json_encode(['error' => 1, "Ocurrió un error con la petición."]);
    die();
}

try {
    # Obtenemos el id del estudio y el tipo del membrete
    $id_estudio = intval(htmlspecialchars($_GET['id_e'], ENT_QUOTES, "utf-8", true));
    $tipo_membrete = htmlspecialchars($_GET['tipo_m'], ENT_QUOTES, "utf-8", true);

    // Obtenemos el encabezado
    $sql = "SELECT concat_ws('.', id_do, ext_do) AS url_encabezado
            FROM venta_conceptos
            LEFT JOIN orden_venta on venta_conceptos.referencia_vc = orden_venta.referencia_ov
            LEFT JOIN sucursales on orden_venta.sucursal_ov = sucursales.id_su
            LEFT JOIN documentos on sucursales.no_temp_su = documentos.aleatorio_do
            WHERE id_vc = ? AND (nombre_do = 'encabezado') AND que_es_do = ?
            ORDER BY id_do DESC";
    $consulta = $horizonte->prepare($sql);
    $consulta->bind_param("is", $id_estudio, $tipo_membrete);
    if (!$consulta->execute()) {
        throw new Exception($consulta->error);
    }
    $encabezado = "sucursales/membretes/files/{$consulta->get_result()->fetch_object()->url_encabezado}";

    // Obtenemos el pie de página
    $sql = "SELECT concat_ws('.', id_do, ext_do) AS url_pie_pagina
            FROM venta_conceptos
            LEFT JOIN orden_venta on venta_conceptos.referencia_vc = orden_venta.referencia_ov
            LEFT JOIN sucursales on orden_venta.sucursal_ov = sucursales.id_su
            LEFT JOIN documentos on sucursales.no_temp_su = documentos.aleatorio_do
            WHERE id_vc = ? AND (nombre_do = 'pie') AND que_es_do = ?
            ORDER BY id_do DESC";
    $consulta = $horizonte->prepare($sql);
    $consulta->bind_param("is", $id_estudio, $tipo_membrete);
    if (!$consulta->execute()) {
        throw new Exception($consulta->error);
    }
    $pie_pagina = "sucursales/membretes/files/{$consulta->get_result()->fetch_object()->url_pie_pagina}";
} catch (\Exception $ex) {
    echo json_encode(['error' => $ex->getMessage()]);
    die();
}

echo json_encode(['encabezado' => $encabezado, "pie_pagina" => $pie_pagina]);
die();
