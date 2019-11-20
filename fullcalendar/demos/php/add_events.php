<?php
require_once('../../../Connections/horizonte.php');
require("../../../funciones/php/values.php");
//initialize variables to hold connection parameters
$username = $username_horizonte;
$dsn = 'mysql:host='.$hostname_horizonte.'; dbname='.$database_horizonte;
$password = $password_horizonte;

// Values received via ajax
$title = mb_strtoupper($_POST['title']);
$start = $_POST['start'];
$end = $_POST['end'];
$a = $_POST["que"]; 
$quien = $_POST["quien"];
$description = $_POST["descripcion"];
$id_user = $_POST["id_user_r"];
$now = date('Y-m-d H:i:s');

// connection to the database
try {
    $bdd = new PDO('mysql:host='.$hostname_horizonte.';charset=UTF8;dbname='.$database_horizonte, $username_horizonte, $password);
} catch (Exception $e) {
    exit($e);
}

// insert the records
$sql = "INSERT INTO events (title, start, end, a_quien, id_quien, description, id_usuario_reg, fecha_reg) VALUES (:title, :start, :end, :a, :quien, :description, :id_user, :now )";
$q = $bdd->prepare($sql);
$q->execute(array(':title' => $title, ':start' => $start, ':end' => $end, ':a' => $a, ':quien' => $quien, ':description' => $description, ':id_user' => $id_user, ':now' => $now));
?>