<?php
require_once('../../../Connections/horizonte.php');
//initialize variables to hold connection parameters
$username = $username_horizonte;
$dsn = 'mysql:host='.$hostname_horizonte.'; dbname='.$database_horizonte;
$password = $password_horizonte;

$id = $_POST['id'];
try {
    $bdd = new PDO('mysql:host='.$hostname_horizonte.';charset=UTF8;dbname='.$database_horizonte, $username_horizonte, $password);
} catch (Exception $e) {
    exit('Unable to connect to database.');
}
$sql = "DELETE from events WHERE id=" . $id;
$q = $bdd->prepare($sql);
$q->execute();
?>
