<?php

require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

// Obtenemos los datos del formulario
$impuestosExtra = json_decode($_POST['impuestosExtra'], true);
$clave_sat = htmlentities($_POST['clave_sat'], ENT_QUOTES, 'utf-8');

// Abrimos la conexión con la base de datos
mysql_select_db($database_horizonte, $horizonte);

// Obtenemos el id_sat recién registrado
$sql = "SELECT id_sat FROM catalogo_sat WHERE clave_sat = '$clave_sat'";
$id_sat = mysql_fetch_assoc(mysql_query($sql, $horizonte))['id_sat'];

// Realizamos las consultas de inserción de los nuevos registros
for ($i = 0; $i <= count($impuestosExtra) - 1; $i++) {
    $ia = $impuestosExtra[$i]; // Impuesto Actual
    $idI = $ia['impuesto'];
    $idF = $ia['factor'];
    $idT = $ia['tipo'];
    if ($ia['porcentajeFijo'] >= 1 && $ia['porcentajeFijo'] <= 14 && $ia['porcentajeLibre'] == 0) {
        $idIF = $ia['porcentajeFijo'];
        $sql = "INSERT INTO impuesto_catalogo(id_sat,id_impuesto,id_impuesto_fijo,impuesto_libre,id_factor,id_tipo) VALUES ($id_sat,$idI,$idIF,NULL,$idF,$idT)";
    } elseif ($ia['porcentajeFijo'] == 0 && $ia['porcentajeLibre'] >= 0.01) {
        $iL = $ia['porcentajeLibre'];
        $sql = "INSERT INTO impuesto_catalogo(id_sat,id_impuesto,id_impuesto_fijo,impuesto_libre,id_factor,id_tipo) VALUES ($id_sat,$idI,NULL,$iL,$idF,$idT)";
    } elseif ($ia['porcentajeFijo'] == 0 && $ia['porcentajeLibre'] == 0) {
        $sql = "INSERT INTO impuesto_catalogo(id_sat,id_impuesto,id_impuesto_fijo,impuesto_libre,id_factor,id_tipo) VALUES ($id_sat,$idI,NULL,NULL,$idF,$idT)";
    }
    try {
        $insert = mysql_query($sql, $horizonte);
    } catch (\Throwable $th) {
        throw $th;
        die();
    }
}

echo json_encode(['EXITO' => 'La línea se ha creado']);
die();

// Cerramos la conexión con la base de datos
mysql_close($horizonte);
