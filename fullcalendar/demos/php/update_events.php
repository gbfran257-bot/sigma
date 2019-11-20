<?php
require_once('../../../Connections/horizonte.php');
//initialize variables to hold connection parameters
$username = $username_horizonte;
$dsn = 'mysql:host='.$hostname_horizonte.'; dbname='.$database_horizonte;
$password = $password_horizonte;

/* Values received via ajax */
$id = $_POST['id'];
$title = $_POST['title'];
$start = $_POST['start'];
$end = $_POST['end'];
$a = $_POST["que"]; 
$quien = $_POST["quien"];
$description = $_POST["descripcion"];
$id_user = $_POST["id_user_r"];
$now = date('Y-m-d H:i:s');
$estatus = $_POST["estatus"];

// connection to the database
try {
    $bdd = new PDO('mysql:host='.$hostname_horizonte.';charset=UTF8;dbname='.$database_horizonte, $username_horizonte, $password);
} catch (Exception $e) {
    exit('Unable to connect to database.');
}
// update the records
	$sql = "UPDATE events SET title=?, start=?, end=? WHERE id=?";
	$q = $bdd->prepare($sql);
	$q->execute(array($title, $start, $end, $id));
?>