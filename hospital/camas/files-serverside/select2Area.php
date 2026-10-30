<?php
require("../../../Connections/horizonte.php"); 
/// Cabecera JSON
header('Content-Type: application/json');
/* Database connection information */

$sql =  mysql_pconnect($hostname_horizonte, $username_horizonte, $password_horizonte) or die( 'Could not open connection to server' );
mysql_select_db($database_horizonte, $sql) or die( 'Could not select database '. $database_horizonte);

/// Parámetros recibidos por select2
/************************** Para pruebas, puedes cambiar de $_POST y $_GET y enviar los parámetros search y page ************************/
$search = filter_var($_POST['search'], FILTER_SANITIZE_STRING);
$page = filter_var($_POST['page'], FILTER_SANITIZE_STRING);

// $search = filter_var($_GET['search'], FILTER_SANITIZE_STRING);
// $page = filter_var($_GET['page'], FILTER_SANITIZE_STRING);

/// Tamaño de paginación
$tamPag = 10; 

/// Consulta por todos los areas
$consulta = "select id_a as id, concat('[', clave_a, '] ', nombre_a) as text from areas ";

/// Conteo de todos los areas
$consultaTotal = "select count(*) as cuantos from areas ";

/// Se modifica la consulta para traer la búsqueda de search
if(!empty($search)){
    $search = "%".$search."%"; /// se agrega comodín al inicio y al final
    $filtro = sprintf(" where (clave_a like '%s' or ".
        "nombre_a like '%s' or ".
        "concat('[', clave_a, '] ', nombre_a) like '%s')",
        $search, $search, $search); /// un $search por cada %s
    $consultaTotal .= $filtro;
    $consulta .= $filtro;
}

/// Arreglo con respuesta
$res = array();

// Imprimir la consulta
// echo $consulta .'<br>';

/// Se calcula el número total de resultados
$rResultTotal = mysql_query($consultaTotal, $sql) or die(mysql_error());
$cuantos = mysql_fetch_assoc( $rResultTotal );

/// se ordena por nombre
$consulta .= " order by nombre_a";

/// si la paginación no está vacia, se aplica
if(!empty($page)){
    $consulta .= sprintf(" limit %d, %d", ($page-1)*$tamPag, $tamPag); // se aplica paginación
    $res['pagination']['count'] = $cuantos['cuantos']; // Se guardan el número de resultados totales para scroll
    $res['pagination']['more'] = $cuantos['cuantos'] > ($page*$tamPag); // Se determina si hay más resultados 
}

/// Se realiza la consulta
$rResult = mysql_query($consulta, $sql) or die(mysql_error());
/// se extraen los resultados en "results"
while($fila = mysql_fetch_assoc( $rResult ))
    $res['results'][] = $fila;
/// Se imprime con JSON
echo json_encode($res);