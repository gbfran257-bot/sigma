<?php
// Recibir datos JSON
$data = json_decode(file_get_contents("php://input"), true);

if(isset($data["imagen"])) {
    $imagen = $data["imagen"];

    // Quitar encabezado "data:image/png;base64,"
    $imagen = str_replace("data:image/png;base64,", "", $imagen);
    $imagen = str_replace(" ", "+", $imagen);

    // Decodificar Base64
    $imagenBinaria = base64_decode($imagen);

    // Guardar en archivo
    $nombreArchivo = "../imagenes/firmas_png/firma_" . time() . ".png";
    file_put_contents($nombreArchivo, $imagenBinaria);

    echo "Imagen guardada como: " . $nombreArchivo;
} else {
    echo "No se recibió la imagen.";
}
?>
