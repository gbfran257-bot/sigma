<?php
/**
 * Select2 para consultar y seleccionar una cama ocupado
 */

require("../../../Connections/horizonte.php"); 
/// Cabecera JSON
header('Content-Type: application/json');
/* Database connection information  */

$sql =  mysql_pconnect($hostname_horizonte, $username_horizonte, $password_horizonte) or die( 'Could not open connection to server' );
mysql_select_db($database_horizonte, $sql) or die( 'Could not select database '. $database_horizonte);

/// Parámetros recibidos por select2
/************************** Para pruebas, puedes cambiar de $_POST y $_GET y enviar los parámetros search y page ************************/
$search = isset($_POST['search']) ? filter_var($_POST['search'], FILTER_SANITIZE_STRING) : filter_var("", FILTER_SANITIZE_STRING);
$page = filter_var($_POST['page'], FILTER_SANITIZE_STRING);
$ocupado = filter_var($_POST['ocupado'], FILTER_SANITIZE_STRING);

// $search = filter_var($_GET['search'], FILTER_SANITIZE_STRING);
// $page = filter_var($_GET['page'], FILTER_SANITIZE_STRING);
// $ocupado = isset($_GET['ocupado']) ? filter_var($_GET['ocupado'], FILTER_SANITIZE_STRING) : NULL;

/// Tamaño de paginación
$tamPag = 10; 

/// Consulta por todos los camas
$consulta = "select id_ca as id, concat('[', no_ca, '] ', ubicacion_ca) as text, ocupado_ca as ocupado from camas ";

/// Conteo de todos los camas
$consultaTotal = "select count(*) as cuantos from camas ";

$consultaTotal .= " where";
$consulta .= " where";

/// Verifica si llego el filtro de las camas ocupadas o desocupadas
if ($ocupado === '1' || $ocupado === '0') {
    $consultaTotal .= " ocupado_ca = $ocupado ";
    $consulta .= " ocupado_ca = $ocupado ";
} else {
    $consultaTotal .= " 1 ";
    $consulta .= " 1 ";
} 

$consultaTotal .= "and ";
$consulta .= "and ";

// echo $consultaTotal.' 42<br><br> ';

/// Se modifica la consulta para traer la búsqueda de search
if(!empty($search)){
    $search = "%".$search."%"; /// se agrega comodín al inicio y al final
    $filtro = sprintf("(no_ca like '%s' or ".
        "ubicacion_ca like '%s' or ".
        "concat('[', no_ca, '] ', ubicacion_ca) like '%s')",
        $search, $search, $search); /// un $search por cada %s
    $consultaTotal .= $filtro;
    $consulta .= $filtro;
} else {
    $consultaTotal .= " 1 ";
    $consulta .= " 1 ";
} 

/// Arreglo con respuesta
$res = array();

// Imprimir la consulta
// echo $consulta .'<br>';

// echo $consultaTotal.' 61<br><br>';

/// Se calcula el número total de resultados
$rResultTotal = mysql_query($consultaTotal, $sql) or die(mysql_error() . 'Linea 60');
$cuantos = mysql_fetch_assoc( $rResultTotal );

/// se ordena por nombre
$consulta .= " order by ubicacion_ca";

/// si la paginación no está vacia, se aplica
if(!empty($page)){
    $consulta .= sprintf(" limit %d, %d", ($page-1)*$tamPag, $tamPag); // se aplica paginación
    $res['pagination']['count'] = $cuantos['cuantos']; // Se guardan el número de resultados totales para scroll
    $res['pagination']['more'] = $cuantos['cuantos'] > ($page*$tamPag); // Se determina si hay más resultados 
}

/// Se realiza la consulta
$rResult = mysql_query($consulta, $sql) or die(mysql_error()  . 'Linea 74');
/// se extraen los resultados en "results"
while($fila = mysql_fetch_assoc( $rResult ))
    $res['results'][] = $fila;
/// Se imprime con JSON
echo json_encode($res);