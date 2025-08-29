<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitar firma</title>
    <link rel="stylesheet" href="pacientes/firmas/estilo.css">
</head>

<body>
    <label>Identificador:</label>
    <input type="number" id="idf" name="idf"></input>
    <p>Firmar a continuación:</p>
    <canvas id="canvas"></canvas>
    <br>
    <button id="btnLimpiar">Limpiar</button>
    <button id="btnDescargar" hidden>Descargar</button>
    <button id="btnGenerarDocumento" hidden>Pasar a documento</button>
    <button id="btnGuardarFirma">Guardar</button>
    <br>
    <script src="pacientes/firmas/script.js"></script>
</body>

</html>