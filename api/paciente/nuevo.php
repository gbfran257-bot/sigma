<?php
require("../../Connections/horizonte.php");

// Configura la conexión a la base de datos
$servername = $hostname_horizonte;
$username = $username_horizonte;
$password = $password_horizonte;
$dbname = $database_horizonte;
// Crea la conexión
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Verifica si hay errores en la conexión
if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}
// Verifica si se recibieron los datos necesarios
if (isset($_POST['usuario']) && isset($_POST['password']) && isset($_POST['curp'])) {
    // Escapa los valores recibidos para evitar inyecciones SQL
    $usuario = mysqli_real_escape_string($conn, $_POST['usuario']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $curp = mysqli_real_escape_string($conn, $_POST['curp']);
    // Encripta la contraseña utilizando la función password_hash()
    $hash = password_hash($password, PASSWORD_DEFAULT);
    // Inserta el nuevo registro en la tabla app_pacientes
    try {
        // Crea la consulta SQL para insertar un nuevo registro
        $sql = "INSERT INTO app_pacientes (usuario, password, curp) VALUES ('$usuario', '$hash', '$curp')";
        // Ejecuta la consulta SQL y verifica si hubo errores
        if (mysqli_query($conn, $sql)) {
            // Obtiene el ID del nuevo registro insertado
            $id = mysqli_insert_id($conn);
            // Devuelve un JSON con el ID del nuevo registro
            echo json_encode(array('id' => $id));
        } else {
            // Devuelve un JSON con los detalles del error
            echo json_encode(array('error' => mysqli_error($conn)));
        }
    } catch(mysqli_sql_exception $e) {
        // Captura la excepción y devuelve un mensaje de error
        $response = ["error" => "El usuario ya existe en la base de datos"];
        echo json_encode($response);
    }
} else {
    // Devuelve un JSON con un mensaje de error si no se recibieron los datos necesarios
    echo json_encode(array('error' => 'Se requieren los campos "usuario", "password" y "curp"'));
}

// Cierra la conexión a la base de datos
mysqli_close($conn);
