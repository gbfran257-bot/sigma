<?php //guard(); para cerrar la sisión por inactividad
	include_once 'recursos/utilities.php';
	include_once 'partes/parseLogin.php';
    include_once 'recursos/session.php';
    if ((isset($_SESSION['MM_Username']) || isCookieValid($db))) {
    } else {
        echo "<script> window.location.href = 'login.php'; </script>";
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitar firma</title>
    <link rel="stylesheet" href="pacientes/firmas/estilo.css">
    <script src="sweetalert/dist/sweetalert.min.js"></script>
    <link href="sweetalert/dist/sweetalert.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <input id="userId" name="userId" type="hidden" value="1" />
    <label>ID Paciente:</label>
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

<script>
    // Toma el valor de la sesión PHP y lo asigna a una variable JavaScript
    var userId1 = <?php echo json_encode($_SESSION['id']); ?>;
    document.getElementById("userId").value = userId1;
</script>