<?php
header('Content-Type: application/json');
require("../Connections/horizonte.php");
// require("../../funciones/php/values.php");

// $host_db = "localhost";
// $user_db = "preunisa_fredd";
// $pass_db = "frederic13FER";
// $db_name = "preunisa_sigma_cruzroja_test";

// $con = mysql_connect($host_db,$user_db,$pass_db);
// mysql_select_db($db_name, $con);

mysql_select_db($database_horizonte, $horizonte);

$user = filter_var($_POST["user"], FILTER_SANITIZE_STRING);
$pass = filter_var($_POST["password"], FILTER_SANITIZE_STRING);

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
    // $cookie_name = "token";
    // $cookie_value = $token;
    // setcookie($cookie_name, $cookie_value, time() + (86400 * 30 ), "/"); // 86400 = 1 day "/" aplica al directorio de raiz adecuarlo.
} else {
    echo json_encode(array("error"=>"fail"));
}

?>