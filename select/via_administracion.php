<?php
require("../Connections/horizonte.php"); 
/// Cabecera JSON
header('Content-Type: application/json');
/* Database connection information */
$sql =  mysql_pconnect($hostname_horizonte, $username_horizonte, $password_horizonte) or die( 'Could not open connection to server' );
mysql_select_db($database_horizonte, $sql) or die( 'Could not select database '. $database_horizonte);
/// Parámetros recibidos por select2
/************************** Para pruebas, puedes cambiar de $_POST y $_GET y enviar los parámetros search y page ************************/
$search = filter_var($_POST['search'], FILTER_SANITIZE_STRING);
$page = filter_var($_POST['page'], FILTER_SANITIZE_STRING);
/// Tamaño de paginación
$tamPag = 10; 

/// Consulta por todos los pacientes
// $consulta = "select c.aleatorio_c as id, c.concepto_to as text from conceptos c where c.id_tipo_concepto_to = 3";
$consulta = "SELECT concepto as id, concepto as text FROM catalogo_via_administracion where 1=1";
/// Conteo de todos los pacientes
// $consultaTotal = "select count(*) as cuantos from conceptos c where 1=1";
$consultaTotal = "select count(*) as cuantos from catalogo_via_administracion where 1=1";

/// Se modifica la consulta para traer la búsqueda de search
if(!empty($search)){
    $search = "%".$search."%"; /// se agrega comodín al inicio y al final
    // $filtro = sprintf(" and (c.concepto_to like '%s')",
    $filtro = sprintf(" and (concepto like '%s')",
        $search); /// un $search por cada %s
    $consultaTotal .= $filtro;
    $consulta .= $filtro;
    // echo $consulta;
}

/// Arreglo con respuesta
$res = array();
// echo $consultaTotal;
/// Se calcula el número total de resultados
$rResultTotal = mysql_query($consultaTotal, $sql) or die(mysql_error());
$cuantos = mysql_fetch_assoc( $rResultTotal );

/// se ordena por nombre
// $consulta .= " order by via_administracion_med";

/// si la paginación no está vacia, se aplica
if(!empty($page)){
    $consulta .= sprintf(" limit %d, %d", ($page-1)*$tamPag, $tamPag); // se aplica paginación
    $res['pagination']['count'] = $cuantos['cuantos']; // Se guardan el número de resultados totales para scroll
    $res['pagination']['more'] = $cuantos['cuantos'] > ($page*$tamPag); // Se determina si hay más resultados 
}
/// Se realiza la consulta
// echo $consulta;
// echo $consulta;
$rResult = mysql_query($consulta, $sql) or die(mysql_error());
/// se extraen los resultados en "results"
while($fila = mysql_fetch_assoc( $rResult ))
    $res['results'][] = $fila;
/// Se imprime con JSON
echo json_encode($res);


/**
 * 
 * 
function select2ini(donde, url, ph){
    $(donde).select2({
        language: "es",
        width: "off",
        allowClear: true,
        ajax: {
            url: 'select/'+url,
            type: "post",
            data: function (params) {
                var query = {
                    search: params.term,
                    page: params.page || 1
                };
                return query;
            }
        },
        placeholder: ph
    });
}
select2ini("#selectVacio", "pacientes.php", "Placeholder para mostrar")
 * 
 * 
 **/