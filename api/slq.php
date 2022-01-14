<?php
header('Access-Control-Allow-Origin: *'); 
header('Content-Type: application/json');
require("../Connections/horizonte.php");

// $host_db = "localhost";
// $user_db = "preunisa_fredd";
// $pass_db = "frederic13FER";
// $db_name = "preunisa_sigma_cruzroja_test";

// $con = mysqli_connect($host_db,$user_db,$pass_db); //cambiar
// mysqli_select_db($con,$db_name); //cambiar


mysql_select_db($database_horizonte, $horizonte);

/* check token */
// $cook = htmlspecialchars($_COOKIE["token"]);
$cook = filter_var($_POST["cookie"],FILTER_SANITIZE_STRING);

$semanaPasada = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s'). " -7 days"));

$sql = "SELECT * FROM usuarios WHERE token='" . $cook . "' AND fecha_token < $semanaPasada"; // Consulta del token en la base de datos 
$result = mysqli_query($con,$sql);
$row = mysqli_fetch_assoc($result);
if( mysqli_num_rows($result) == 0 ) {
    $sql = "UPDATE usuarios SET token = null WHERE token='" . $cook . "'"; // Consulta del token en la base de datos 
    $result = mysqli_query($con,$sql);
    die;
}
/* token */

$tabla = filter_var($_POST["tabla"], FILTER_SANITIZE_STRING);
$campos = filter_var($_POST["campos"], FILTER_SANITIZE_STRING);
$condicion = filter_var($_POST["condicion"], FILTER_SANITIZE_STRING);
$valores = filter_var($_POST["valores"], FILTER_SANITIZE_STRING);
$comando =  filter_var($_POST["comando"], FILTER_SANITIZE_STRING);

if ($comando=="INSERT") {
    $sql = "INSERT INTO " . $tabla . " (" . $campos . ") VALUES(" . $valores . ") ";
}

if ($comando=="UPDATE") {
    $sql = "UPDATE " . $tabla . " SET " . $_["campos_valores"] . " WHERE " . $condicion ;
}

if ($comando=="SELECT") {
    $sql = "SELECT " . $_POST["limitador"] . " FROM " . $tabla ." WHERE " . $condicion ;
}

if ($comando=="DELETE") {
    $sql = "DELETE FROM " . $tabla . " WHERE " . $condicion ;
}
$result = mysqli_query($con,$sql);
$emparray = array();
while( $row = mysqli_fetch_assoc($result) )
{
    $emparray[] = $row;
}
echo json_encode($emparray);
mysqli_close($con);
?>

