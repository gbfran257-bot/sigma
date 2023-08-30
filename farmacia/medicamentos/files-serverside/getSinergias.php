<?php
require("../../../Connections/horizonte2.php");

// Abrimos la conexion con la base de datos.
mysqli_select_db($horizonte, $database);

$id_medicamento = intval(htmlspecialchars($_POST['id_medicamento'], ENT_QUOTES, 'utf-8', true));

$select = "SELECT s.id_medicamento FROM sinergia s LEFT JOIN medicamento_sinergia ms ON s.id = ms.id_sinergia WHERE ms.id_medicamento = {$id_medicamento}";
$ids = mysqli_query($horizonte, $select);
if (!$ids) {
    echo json_encode(['ERROR' => 'Ocurrió un error al obtener las sinergias del medicamento.']);
    die();
}

$sinergias = [];
while ($id_sinergia = mysqli_fetch_assoc($ids)['id_medicamento']) {
    $select = "SELECT c.concepto_to as medicamento FROM conceptos c LEFT JOIN medicamento_sinergia ms ON c.id_to = ms.id_medicamento WHERE c.id_to = $id_sinergia";
    array_push($sinergias, mysqli_fetch_assoc(mysqli_query($horizonte, $select))['medicamento']);
}

echo json_encode($sinergias);
die();

// Cerramos la conexion con la base de datos
mysqli_close($horizonte);
