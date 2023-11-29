<?php

try {
    $id_compra = intval(htmlentities($_POST['id_compra']));
    $referencia_compra = htmlentities($_POST['referencia_compra']);

    require("../../../Connections/horizonte2.php");

    $query = "SELECT CONCAT(u.usuario_u, ' ', DATE_FORMAT(s.fecha_registro, '%d/%m/%Y'), ' ', DATE_FORMAT(s.fecha_registro, '%H:%i:%s')) AS info FROM usuarios u LEFT JOIN stock_has_bach s ON s.usuario_registro = u.id_u WHERE s.id = {$id_compra} AND s.referencia_compra = '{$referencia_compra}'";

    if (!$resultado_query = mysqli_query($horizonte, $query)) {
        throw new Exception(mysqli_error($horizonte));
    }

    echo json_encode(['success' => mysqli_fetch_object($resultado_query)->info]);
} catch (\Exception $ex) {
    echo json_encode(['error' => $ex->getMessage()]);
}

die();
