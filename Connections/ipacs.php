<?php
// Connections/ipacs.php
date_default_timezone_set('Mexico/General');

$hostname_ipacs = "localhost";
$database_ipacs = "pacsdb";
$username_ipacs = "pacs";
$password_ipacs = "pacs";

// Conectamos al PostgreSQL del Docker usando @ para silenciar mensajes en pantalla si falla
$ipacs = @pg_connect("host=$hostname_ipacs port=5432 dbname=$database_ipacs user=$username_ipacs password=$password_ipacs");

// Si la conexión falla, se guarda silenciosamente en el log del servidor en lugar de romper el JSON
if (!$ipacs) {
    error_log("PACS Connection Error: No se pudo conectar al contenedor Docker en el puerto 5432.");
}
?>