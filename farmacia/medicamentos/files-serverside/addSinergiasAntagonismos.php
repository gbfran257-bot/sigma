<?php
require("../../../Connections/horizonte.php");

// Abrimos la conexion con la base de datos.
mysql_select_db($database_horizonte, $horizonte);

$sinergias = json_decode($_POST['sinergias']);
$antagonismos = json_decode($_POST['antagonismos']);

// Obtenemos el id del medicamento recién registrado
$selectID = "SELECT MAX(id_to) AS id_to_medicamento FROM conceptos";
$idMedicamento = intval(mysql_fetch_assoc(mysql_query($selectID, $horizonte))['id_to_medicamento']);

// Primero registramos todas las sinergias
for ($i = 0; $i < count($sinergias); $i++) {
    // Insertamos las sinergias
    $insertSinergia = "INSERT INTO sinergia(id_medicamento) VALUES($sinergias[$i])";
    $resultado = mysql_query($insertSinergia, $horizonte);

    if (!$resultado) {
        echo json_encode(['ERROR' => 'Ocurrió un error al registrar las sinergias']);
        die();
    }

    // Obtenemos el id de la sinergia recién registrada
    $selectIdSinergia = "SELECT MAX(id) AS id_sinergia FROM sinergia";
    $idSinergia = mysql_fetch_assoc(mysql_query($selectIdSinergia, $horizonte))['id_sinergia'];

    // insertamos la relación medicamento - sinergia
    $insertMedicamentoSinergia = "INSERT INTO medicamento_sinergia(id_medicamento, id_sinergia) VALUES($idMedicamento, $idSinergia)";
    $resultado = mysql_query($insertMedicamentoSinergia, $horizonte);

    if (!$resultado) {
        echo json_encode(['ERROR' => 'Ocurrió un error al registrar las sinergias del medicamento']);
        die();
    }
}

// Después insertamos todos los antagonismos
for ($i = 0; $i < count($antagonismos); $i++) {
    // Insertamos las antagonismos
    $insertAntagonismo = "INSERT INTO antagonismo(id_medicamento) VALUES($antagonismos[$i])";
    $resultado = mysql_query($insertAntagonismo, $horizonte);

    if (!$resultado) {
        echo json_encode(['ERROR' => 'Ocurrió un error al registrar los antagonismos']);
        die();
    }

    // Obtenemos el id del antagonismo recién registrada
    $selectIdAntagonismo = "SELECT MAX(id) AS id_antagonismo FROM antagonismo";
    $idAntagonismo = mysql_fetch_assoc(mysql_query($selectIdAntagonismo, $horizonte))['id_antagonismo'];

    // insertamos la relación medicamento - antagonismo
    $insertMedicamentoAntagonismo = "INSERT INTO medicamento_antagonismo(id_medicamento, id_antagonismo) VALUES($idMedicamento, $idAntagonismo)";
    $resultado = mysql_query($insertMedicamentoAntagonismo, $horizonte);

    if (!$resultado) {
        echo json_encode(['ERROR' => 'Ocurrió un error al registrar los antagonismos del medicamento']);
        die();
    }
}

echo json_encode(['EXITO' => "El medicamento se ha creado satisfactoriamente"]);
die();

// Cerramos la conexion con la base de datos
mysql_close($horizonte);
