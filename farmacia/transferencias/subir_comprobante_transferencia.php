<?php

date_default_timezone_set("America/Mexico_City");

try {
    require("../../Connections/horizonte2.php");

    if (!isset($_FILES['comprobante_factura'])) {
        throw new Exception("Selecciona un archivo válido.");
    }

    if (!isset($_POST['referencia'])) {
        throw new Exception("Ocurrió un error.");
    }

    $comprobante_factura = $_FILES['comprobante_factura'];
    $referencia = $_POST['referencia'];
    $id_usuario = $_POST['id_usuario'];

    $tipo_archivo = explode(".", $comprobante_factura['name']);
    $fecha = date("Y-m-d");
    $hora = date("H-i-s");
    $nombre_comprobante_factura = "comprobante_transferencia_" . $referencia . "_" . $fecha . "_" . $hora . "." . $tipo_archivo[count($tipo_archivo) - 1];

    if (!move_uploaded_file($comprobante_factura['tmp_name'], "./comprobantes/" . $nombre_comprobante_factura)) {
        throw new Exception("Ocurrió un error al subir el archivo.");
    }

    $query_subir_comprobante = "INSERT INTO comprobante_transferencia(referencia, nombre_archivo, id_usuario, fecha_hora) VALUES('{$referencia}', '{$nombre_comprobante_factura}', {$id_usuario}, '{$fecha} {$hora}')";
    if (!$resultado = mysqli_query($horizonte, $query_subir_comprobante)) {
        throw new Exception(mysqli_error($horizonte));
    }

    echo json_encode(['success' => "Comprobante subido correctamente."]);

    mysqli_close($horizonte);
} catch (\Exception $ex) {
    echo json_encode(['error' => $ex->getMessage()]);
}

die();
