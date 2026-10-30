<?php
require("../../../Connections/horizonte.php");

// Abrimos la conexion con la base de datos.
mysql_select_db($database_horizonte, $horizonte);

$id_medicamento = intval(htmlentities($_GET['id_medicamento'], ENT_QUOTES, 'utf-8'));

// 1. Obtenemos el id de todos los medicamentos asociados como antagonistas del medicamento seleccionado
$selectIdsAntagonismos = "SELECT a.id_medicamento FROM antagonismo a LEFT JOIN medicamento_antagonismo ma ON a.id = ma.id_antagonismo WHERE ma.id_medicamento = $id_medicamento";
$ids_antagonismos = mysql_query($selectIdsAntagonismos, $horizonte);
if (!$ids_antagonismos) {
    echo json_encode(['ERROR' => 'Ocurrió un error al obtener los antagonismos del medicamento.']);
    die();
}

$medicamentos_antagonistas = [];
while ($id_antagonismo = mysql_fetch_assoc($ids_antagonismos)['id_medicamento']) {
    $selectNombreMedicamento = "SELECT c.concepto_to as medicamento FROM conceptos c LEFT JOIN medicamento_antagonismo ma ON c.id_to = ma.id_medicamento WHERE c.id_to = $id_antagonismo";
    array_push($medicamentos_antagonistas, mysql_fetch_assoc(mysql_query($selectNombreMedicamento, $horizonte))['medicamento']);
}

// 2. Obtenemos el id de todos los medicamentos asociados como sinergias del medicamento seleccionado
$selectIdsSinergias = "SELECT s.id_medicamento FROM sinergia s LEFT JOIN medicamento_sinergia ms ON s.id = ms.id_sinergia WHERE ms.id_medicamento = $id_medicamento";
$ids_sinergias = mysql_query($selectIdsSinergias, $horizonte);
if (!$ids_sinergias) {
    echo json_encode(['ERROR' => 'Ocurrió un error al obtener las sinergias del medicamento.']);
    die();
}

$medicamentos_sinergias = [];
while ($id_sinergia = mysql_fetch_assoc($ids_sinergias)['id_medicamento']) {
    $selectNombreMedicamento = "SELECT c.concepto_to as medicamento FROM conceptos c LEFT JOIN medicamento_sinergia ms ON c.id_to = ms.id_medicamento WHERE c.id_to = $id_sinergia";
    array_push($medicamentos_sinergias, mysql_fetch_assoc(mysql_query($selectNombreMedicamento, $horizonte))['medicamento']);
}

echo json_encode(['sinergias' => $medicamentos_sinergias, 'antagonismos' => $medicamentos_antagonistas]);
die();

// Cerramos la conexion con la base de datos
mysql_close($horizonte);
