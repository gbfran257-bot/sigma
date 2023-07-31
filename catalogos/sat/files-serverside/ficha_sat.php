<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

$id = sqlValue($_POST["id_um"], "int");

mysql_select_db($database_horizonte, $horizonte);

$sql = "SELECT clave_sat, descripcion_sat, iva, impuesto_libre, impuesto_tipo.id AS id_tipo, impuesto.id AS id_impuesto, impuesto_factor.id AS id_factor, impuesto_fijo.id AS id_impuesto_fijo, impuesto_catalogo.id AS id_impuesto_catalogo
        FROM catalogo_sat
        LEFT JOIN impuesto_catalogo ON catalogo_sat.id_sat = impuesto_catalogo.id_sat
        LEFT JOIN impuesto_tipo ON impuesto_catalogo.id_tipo = impuesto_tipo.id
        LEFT JOIN impuesto ON impuesto_catalogo.id_impuesto = impuesto.id
        LEFT JOIN impuesto_factor ON impuesto_catalogo.id_factor = impuesto_factor.id
        LEFT JOIN impuesto_fijo ON impuesto_catalogo.id_impuesto_fijo = impuesto_fijo.id
        WHERE catalogo_sat.id_sat = $id";

$result = mysql_query($sql, $horizonte) or die(mysql_error());
$registros = [];
while ($registro = mysql_fetch_assoc($result)) {
        array_push($registros, $registro);
}

echo json_encode($registros);

//Cerrar conexión a la Base de Datos
mysql_close($horizonte);
