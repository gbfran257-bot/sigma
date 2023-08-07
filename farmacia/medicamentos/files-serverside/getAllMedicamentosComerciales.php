<?php
require("../../../Connections/horizonte.php");

// Abrimos la conexion con la base de datos.
mysql_select_db($database_horizonte, $horizonte);

$select = "SELECT id_to AS id_concepto_medicamento, concepto_to AS concepto_medicamento
            FROM conceptos
            LEFT JOIN medicamentos ON medicamentos.id_med = conceptos.id_medicamento_g
            WHERE conceptos.id_tipo_concepto_to = 5
            ORDER BY concepto_medicamento";
$respuesta = mysql_query($select, $horizonte);

if (!$respuesta) {
    echo json_encode(['ERROR' => mysql_error()]);
    die();
}

$medicamentos = [];
while ($medicamento = mysql_fetch_assoc($respuesta)) {
    array_push($medicamentos, $medicamento);
}

echo json_encode(['medicamentos' => $medicamentos]);
die();

// Cerramos la conexion con la base de datos
mysql_close($horizonte);
