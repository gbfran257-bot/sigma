<?php

require("../../../Connections/horizonte2.php");

$id_consulta = intval(htmlspecialchars($_POST['id_consulta'], ENT_QUOTES, 'utf-8', true));
$id_usuario = intval(htmlspecialchars($_POST['id_usuario'], ENT_QUOTES, 'utf-8', true));
$fecha = date('Y/m/d');
$hora = date("H:i:s");
$mensaje = "";

// Obtenemos el nombre del usuario que autorizó la receta con medicamentos antagónicos
$select = $horizonte->prepare("SELECT nombre_u AS nombre, apaterno_u AS paterno, amaterno_u AS materno FROM usuarios WHERE id_u = ?");
$select->bind_param("i", $id_usuario);

if (!$select->execute()) {
    echo json_encode(['ERROR' => $horizonte->error]);
    die();
}

// Definimos el mensaje del reporte
$usuario = $select->get_result()->fetch_object();
$mensaje = "El usuario {$usuario->nombre} {$usuario->paterno} {$usuario->materno} aprobó la receta con medicamentos antagónicos.";

// Insertamos el reporte generado
$insert = $horizonte->prepare("INSERT INTO reporte_consulta_antagonismo(id_consulta, id_usuario, fecha, hora, mensaje) VALUES(?, ?, ?, ?, ?)");
$insert->bind_param("iisss", $id_consulta, $id_usuario, $fecha, $hora, $mensaje);

if (!$insert->execute()) {
    echo json_encode(['ERROR' => $horizonte->error]);
    die();
}

echo json_encode(['EXITO' => 'Se ha hecho un reporte de tu decisión']);
die();

$horizonte->close();
