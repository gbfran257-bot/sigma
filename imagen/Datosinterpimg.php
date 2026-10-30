<?php
// Devuelve el contenido guardado de la interpretación de imagen (vacío si no existe).
include_once '../../recursos/session.php';
include_once '../../Connections/database.php';

$idE = isset($_POST['idE']) ? (int)$_POST['idE'] : 0;
$st = $mysqli->prepare("SELECT contenido FROM usg_interpretacion_imagen WHERE id_vc=?");
$st->bind_param('i', $idE);
$st->execute();
$st->bind_result($contenido);
if($st->fetch()){ echo $contenido; }
