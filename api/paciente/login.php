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
if (isset($_POST['usuario']) && isset($_POST['password'])) {
    // Escapa los valores recibidos para evitar inyecciones SQL
    $usuario = mysqli_real_escape_string($conn, $_POST['usuario']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    // Encripta la contraseña utilizando la función password_hash()
    $hash = password_hash($password, PASSWORD_DEFAULT);
    // Inserta el nuevo registro en la tabla app_pacientes
    try {
        // Crea la consulta SQL para insertar un nuevo registro
        $sql = "SELECT id, password FROM app_pacientes WHERE usuario = '$usuario';";
        // Ejecuta la consulta SQL y verifica si hubo errores
        if ($result = mysqli_query($conn, $sql)) {
            // Verifica si se encontró un registro para el usuario
            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                $hash = $row['password'];
                // Verifica si la contraseña coincide con el hash almacenado
                if (password_verify($password, $hash)) {
                    // Autenticación exitosa, devuelve el ID del paciente
                    $response = ["id" => $row['id']];
                    echo json_encode($response);
                } else {
                    // Contraseña incorrecta
                    $response = ["error" => "Contraseña incorrecta"];
                    echo json_encode($response);
                }
            } else {
                // Usuario no encontrado
                $response = ["error" => "El usuario no existe"];
                echo json_encode($response);
            }
            // Libera el resultado de la consulta
            mysqli_free_result($result);
        } else {
            // Error en la consulta SQL
            $response = ["error" => "Error en la consulta SQL: " . mysqli_error($conn)];
            echo json_encode($response);
        }
    } catch(mysqli_sql_exception $e) {
        // Captura la excepción y devuelve un mensaje de error
        $response = ["error" => "El usuario no existe en la base de datos"];
        echo json_encode($response);
    }
} else {
    // Devuelve un JSON con un mensaje de error si no se recibieron los datos necesarios
    echo json_encode(array('error' => 'Se requieren los campos "usuario", "password" y "curp"'));
}

// Cierra la conexión a la base de datos
mysqli_close($conn);
