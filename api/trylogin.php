<?php
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');
}

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {      
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, PATCH, HEAD, PUT, DELETE");
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
}
header('Content-Type: application/json');
require("../Connections/horizonte.php");
mysql_select_db($database_horizonte, $horizonte);
$user = filter_var($_GET["user"], FILTER_SANITIZE_STRING);
$pass = filter_var($_GET["password"], FILTER_SANITIZE_STRING);
$sql = "SELECT id_u, contrasena_u FROM usuarios WHERE usuario_u = '" . $user . "'"; // Adecuar a su db y tabla
$result = mysql_query($sql);
$row = mysql_fetch_assoc($result);
if( mysql_num_rows($result) >0 && password_verify($pass, $row['contrasena_u'])) { 
    $token = md5(uniqid(rand(), true));
    $token_array = array("token"=>$token);
    $empresa = array("empresa"=>$row["id_u"]);
    echo json_encode( array_merge($token_array,$empresa));
    $sql = "UPDATE usuarios SET token='" . $token . "', fecha_token = now() WHERE id_u = '" . $row['id_u'] ."'"; // adecuar a su tabla
    $result = mysql_query($sql);
} else {
    echo json_encode(array("error"=>"fail"));
}
?>