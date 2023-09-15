<?php
require("../../../Connections/horizonte.php");

// Abrimos la conexion con la base de datos.
mysql_select_db($database_horizonte, $horizonte);

$id_medicamento = intval(htmlspecialchars($_POST['id_medicamento'], ENT_QUOTES, 'utf-8', true));

$select = "SELECT * FROM conceptos WHERE conceptos.id_to = $id_medicamento";
$medicamento = mysql_query($select, $horizonte);
if (!$medicamento) {
    echo json_encode(['ERROR' => 'Ocurrió un error al obtener la información del medicamento.']);
    die();
}

echo json_encode(mysql_fetch_assoc($medicamento));
die();

// Cerramos la conexion con la base de datos
mysql_close($horizonte);
