<?php

require("../../Connections/horizonte2.php");

$id_medicamento_receta = intval(htmlspecialchars($_POST['id_medicamento_receta'], ENT_QUOTES, 'utf-8', true));

$select = $horizonte->prepare("SELECT c.id_to AS id_medicamento_comercial FROM medicamentos_receta mr LEFT JOIN conceptos c ON c.id_to = mr.id_med_mr WHERE mr.id_mr = ? LIMIT 1");
$select->bind_param('i', $id_medicamento_receta);

if (!$select->execute()) {
    echo json_encode(['ERROR' => $horizonte->error]);
    die();
}

echo json_encode(['ID' => $select->get_result()->fetch_object()->id_medicamento_comercial]);
die();

$horizonte->close();
