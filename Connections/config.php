<?php
// config.php - Configuración de conexión a la base de datos

// Datos de conexión para base de datos "prueba"
$db_host = "localhost";
$db_user = "sigmauser";
$db_password = "root";
$db_name = "pacsdb";

// Crear conexión usando MySQLi
$mysql = mysqli_connect($db_host, $db_user, $db_password, $db_name);

// Verificar conexión
if (!$mysql) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Establecer charset a UTF-8
mysqli_set_charset($mysql, "utf8");

// Configurar zona horaria (México)
date_default_timezone_set('America/Mexico_City');
?>