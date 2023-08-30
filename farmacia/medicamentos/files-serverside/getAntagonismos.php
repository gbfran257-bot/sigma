<?php
require("../../../Connections/horizonte.php");

// Abrimos la conexion con la base de datos.
mysql_select_db($database_horizonte, $horizonte);

$id_medicamento = intval(htmlspecialchars($_POST['id_medicamento'], ENT_QUOTES, 'utf-8', true));

$select = "SELECT a.id_medicamento FROM antagonismo a LEFT JOIN medicamento_antagonismo ma ON a.id = ma.id_antagonismo WHERE ma.id_medicamento = $id_medicamento";
$ids = mysql_query($select, $horizonte);
if (!$ids) {
    echo json_encode(['ERROR' => 'Ocurrió un error al obtener los antagonismos del medicamento.']);
    die();
}

$antagonismos = [];
while ($id_antagonismo = mysql_fetch_assoc($ids)['id_medicamento']) {
    $select = "SELECT c.concepto_to as medicamento FROM conceptos c LEFT JOIN medicamento_antagonismo ma ON c.id_to = ma.id_medicamento WHERE c.id_to = $id_antagonismo";
    array_push($antagonismos, mysql_fetch_assoc(mysql_query($select, $horizonte))['medicamento']);
}

echo json_encode($antagonismos);
die();

// Cerramos la conexion con la base de datos
mysql_close($horizonte);
