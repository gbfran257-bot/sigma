<?php

require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

// Abrimos la conexión con la base de datos
mysql_select_db($database_horizonte, $horizonte);

// Obtenemos los datos del formulario
$impuestos = json_decode($_POST['impuestos'], true);

for ($i = 0; $i <= count($impuestos) - 1; $i++) {
    $ie = $impuestos[$i];
    $idIC = $ie['id_impuesto_catalogo'];
    $idI = $ie['id_impuesto'];
    $idIF = $ie['id_tasa_cuota'];
    $iL = $ie['monto_impuesto'];
    $idF = $ie['id_factor'];
    $idT = $ie['id_tipo'];

    if ($idIF >= 1 && $idIF <= 14 && $iL == 0) {
        $sql = "UPDATE impuesto_catalogo SET id_impuesto = $idI, id_impuesto_fijo = $idIF, impuesto_libre = NULL, id_factor = $idF, id_tipo = $idT WHERE id = $idIC";
    } elseif ($idIF == 0 && $iL >= 0.01) {
        $sql = "UPDATE impuesto_catalogo SET id_impuesto = $idI, id_impuesto_fijo = NULL, impuesto_libre = $iL, id_factor = $idF, id_tipo = $idT WHERE id = $idIC";
    } elseif ($idIF == 0 && $ie['porcentajeLibre'] == 0) {
        $sql = "UPDATE impuesto_catalogo SET id_impuesto = $idI, id_impuesto_fijo = NULL, impuesto_libre = NULL, id_factor = $idF, id_tipo = $idT WHERE id = $idIC";
    }

    try {
        $update = mysql_query($sql, $horizonte);
    } catch (\Throwable $th) {
        echo json_encode([$th->getMessage()]);
        die();
    }
}

echo json_encode(['EXITO' => 'La línea se ha creado']);
die();

// Cerramos la conexión con la base de datos
mysql_close($horizonte);
