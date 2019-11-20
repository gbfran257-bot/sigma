<?php
require_once('../../../Connections/horizonte.php');
require("../../../funciones/php/values.php");
//initialize variables to hold connection parameters
$username = $username_horizonte;
$dsn = 'mysql:host='.$hostname_horizonte.'; dbname='.$database_horizonte;
$password = $password_horizonte;

$a = sqlValue($_GET["que"], "int"); $quien = sqlValue($_GET["quien"], "int");

// List of events
$json = array();

// Query that retrieves events
$request = "SELECT * FROM events where a_quien = $a and id_quien = $quien ORDER BY id asc";

// connection to the database
try {
    $bdd = new PDO('mysql:host='.$hostname_horizonte.';charset=UTF8;dbname='.$database_horizonte, $username_horizonte, $password);
} catch (Exception $e) {
    exit('Unable to connect to database.');
}
// Execute the query
$result = $bdd->query($request) or die(print_r($bdd->errorInfo()));

// sending the encoded result to success page
echo json_encode($result->fetchAll(PDO::FETCH_ASSOC));
?>