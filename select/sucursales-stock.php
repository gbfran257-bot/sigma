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
$idSu = filter_var($_POST['idSu'], FILTER_SANITIZE_STRING);
/// Tamaño de paginación
$tamPag = 10; 

//revisamos si es multisucursal
mysql_select_db($database_horizonte, $horizonte);
$multisucursal = mysql_query("SELECT multisucursal_u FROM usuarios WHERE id_u = ".$_GET['id_u'], $horizonte) or die (mysql_error());
$revisar_multisucursal = mysql_fetch_row($multisucursal);

if($revisar_multisucursal[0]==1){
    $consulta = "select s.id_su as id, s.nombre_su as text from sucursales s where id_su != $idSu ";
}else{
    $consulta = "select s.id_su as id, s.nombre_su as text from sucursales s LEFT JOIN sucursales_usuarios su ON su.id_sucursal_su = s.id_su WHERE su.id_usuario_su = ".$_GET['id_u']." GROUP BY su.id_sucursal_su ";
}

/// Conteo de todos los pacientes
$consultaTotal = "select count(*) as cuantos from sucursales s where 1=1";

/// Se modifica la consulta para traer la búsqueda de search
if(!empty($search)){
    $search = "%".$search."%"; /// se agrega comodín al inicio y al final
    $filtro = sprintf(" and (s.nombre_su like '%s' " . 
        ")",
        $search); /// un $search por cada %s
    $consultaTotal .= $filtro;
    $consulta .= $filtro;
}

/// Arreglo con respuesta
$res = array();
// echo $consultaTotal;
/// Se calcula el número total de resultados
$rResultTotal = mysql_query($consultaTotal, $sql) or die(mysql_error());
$cuantos = mysql_fetch_assoc( $rResultTotal );

/// se ordena por nombre
$consulta .= " order by s.nombre_su";

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