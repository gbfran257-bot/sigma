<?php

require("../../../Connections/horizonte2.php");
require("../../../funciones/php/values.php");

$aColumns = array('s.id', 'tt.id_transferencia', 's.referencia_compra', 'g.nombre_generico_med', 'c.concepto_to', 's.Lote', 's.id', 'CONCAT_WS("<br>", u.usuario_u, DATE_FORMAT(s.fecha_update,"%d/%c/%Y"), DATE_FORMAT(s.fecha_update,"%H:%i:%s"))', 's.cantidad', 's.fecha_expiracion', '(select nombre_su from sucursales WHERE id_su = tt.id_sucursal_destino)', 's.id', 's.id', 's.id_Producto');

$aTables = array('stock_has_bach s');

$sIndexColumn = "s.id";

$sJoin = 'left join transferencia_temporal tt on s.referencia_traspaso_temporal = tt.id_temporal left join conceptos c on c.id_to = s.id_Producto left join stock s1 on s1.id = s.id_stock left join usuarios u on u.id_u = s.usuario_registro left join sucursales su on su.id_su = s1.id_su left join medicamentos g on g.id_med = c.id_medicamento_g left join proveedores pr on pr.clave_pr = s.id_proveedor';

$resultAU = mysqli_query($horizonte, "SELECT multisucursal_u, idSucursal_u from usuarios where id_u = '$_GET[idU]'") or die(mysqli_error($horizonte));
$rowAU = mysqli_fetch_row($resultAU);
$id_suc = sqlValue($rowAU[1], "int");

$todos = "";
$verde = " AND fecha_expiracion >= CURDATE() + INTERVAL 12 MONTH ";
$amarillo = " AND fecha_expiracion > CURDATE() + INTERVAL 6 MONTH AND fecha_expiracion <= CURDATE() + INTERVAL 11 MONTH ";
$rojo = " AND fecha_expiracion > CURDATE() + INTERVAL 15 DAY AND fecha_expiracion <= CURDATE() + INTERVAL 6 MONTH ";
$negro = " AND fecha_expiracion <= CURDATE() + INTERVAL 15 DAY ";

if(isset($_GET['s_colores']) && $_GET['s_colores'] == 0){
    $condicion_fecha = $todos;
}else if(isset($_GET['s_colores']) && $_GET['s_colores'] == 1){
    $condicion_fecha = $verde;
}else if(isset($_GET['s_colores']) && $_GET['s_colores'] == 2){
    $condicion_fecha = $amarillo;
}else if(isset($_GET['s_colores']) && $_GET['s_colores'] == 3){
    $condicion_fecha = $rojo;
}else if(isset($_GET['s_colores']) && $_GET['s_colores'] == 4){
    $condicion_fecha = $negro;
}

switch($rowAU[0]){
    case 0://Solo vé lo suyo
        if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
          $sWhere="WHERE (tt.fecha_transferencia BETWEEN '$_GET[min]' AND '$_GET[max]' and s.usuario_registro = '$_GET[idU]') AND s.es_traspaso = 1 $condicion_fecha";
        }else{
          $sWhere = "where s.usuario_registro = '$_GET[idU]' AND s.es_traspaso = 1 $condicion_fecha";
        }
    break;
    case 2://Ve todo lo de su sucursal y lo suyo
        if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
          $sWhere="WHERE (tt.fecha_transferencia BETWEEN '$_GET[min]' AND '$_GET[max]' and (s1.id_su = $id_suc or s.usuario_registro = '$_GET[idU]')) AND s.es_traspaso = 1 $condicion_fecha";
        }else{
          $sWhere = "WHERE (s1.id_su = $id_suc or s.usuario_registro = '$_GET[idU]') AND s.es_traspaso = 1 $condicion_fecha";
        }
    break;
    case 1://Ve todo de todas las sucursales
        if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
          $sWhere="WHERE (tt.fecha_transferencia BETWEEN '$_GET[min]' AND '$_GET[max]') AND s.es_traspaso = 1 $condicion_fecha";
        }else{
          $sWhere = "WHERE 1 = 1 AND s.es_traspaso = 1 $condicion_fecha";
        }
    break;
    default:
        echo 'Ha ocurrido un error';
}

/* Database connection information */
$gaSql['user']       = $username;
$gaSql['password']   = $password;
$gaSql['db']         = $database;
$gaSql['server']     = $hostname;

$gaSql['link'] =  $horizonte;

/*  * Paging */
$sLimit = "";
if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
    $sLimit = "LIMIT " . mysqli_real_escape_string($gaSql['link'], $_GET['iDisplayStart']) . ", " . mysqli_real_escape_string($gaSql['link'], $_GET['iDisplayLength']);
}

/* * Ordering */
$sOrder = "GROUP BY tt.id_temporal order by s.id desc";
if (isset($_GET['iSortCol_0'])) {
    $sOrder = "GROUP BY tt.id_temporal ORDER BY v.id_vc desc  ";
    for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
        if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
            $sOrder .= $aColumns[intval($_GET['iSortCol_' . $i])] . " " . mysqli_real_escape_string($gaSql['link'], $_GET['sSortDir_' . $i]) . ", ";
        }
    }

    $sOrder = substr_replace($sOrder, "", -2);
    if ($sOrder == "ORDER BY") {
        $sOrder = "";
    }
}

/*  * Filtering * NOTE this does not match the built-in DataTables filtering which does it * word by word on any field. It's possible to do here, but concerned about efficiency * on very large tables, and MySQL's regex functionality is very limited */

if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
    $sWhere .= "AND (";
    for ($i = 0; $i < count($aColumns); $i++) {
        $sWhere .= $aColumns[$i] . " LIKE '%" . mysqli_real_escape_string($gaSql['link'], $_GET['sSearch']) . "%' OR ";
    }
    $sWhere = substr_replace($sWhere, "", -3);
    $sWhere .= ')';
}

/* Individual column filtering */
for ($i = 0; $i < count($aColumns); $i++) {
    if (isset($_GET['bSearchable_' . $i]) && $_GET['bSearchable_' . $i] == "true" && $_GET['sSearch_' . $i] != '') {
        if ($sWhere == "") {
            $sWhere = "WHERE ";
        } else {
            $sWhere .= " AND ";
        }
        $busqueda = "%" . htmlentities($_GET['sSearch_' . $i]) . "%";
        if($i == 11){
            $sWhere .= $aColumns[10]." LIKE '".$busqueda."' ";
        } else {
            $sWhere .= $aColumns[$i]." LIKE '".$busqueda."' ";
        }
    }
}

/*  * SQL queries  * Get data to display */
$sQuery = "
        SELECT DISTINCT SQL_CALC_FOUND_ROWS " . str_replace(" , ", " ", implode(", ", $aColumns)) . "
        FROM   " . str_replace(" , ", " ", implode(", ", $aTables)) . "
		$sJoin
        $sWhere
        $sOrder
        $sLimit";

$rResult = mysqli_query($gaSql['link'], $sQuery) or die(mysqli_error($gaSql['link']));

/* Data set length after filtering */
$sQuery = " SELECT FOUND_ROWS() ";
$rResultFilterTotal = mysqli_query($gaSql['link'], $sQuery) or die(mysqli_error($gaSql['link']));
$aResultFilterTotal = mysqli_fetch_array($rResultFilterTotal);
$iFilteredTotal = $aResultFilterTotal[0];

/* Total data set length */
$sQuery = "
        SELECT COUNT(" . $sIndexColumn . ")
        FROM   " . $aTables[0];

$rResultTotal = mysqli_query($gaSql['link'], $sQuery) or die(mysqli_error($gaSql['link']));
$aResultTotal = mysqli_fetch_array($rResultTotal);
$iTotal = $aResultTotal[0];

/*  * Output */
$output = [
    "sEcho" => intval($_GET['sEcho']),
    "iTotalRecords" => $iTotal,
    "iTotalDisplayRecords" => $iFilteredTotal,
    "aaData" => []
];
$hh = 0;

while ($aRow = mysqli_fetch_array($rResult)) {
    $hh++;
    $row = [];
    for ($i = 0; $i < count($aColumns); $i++) {
        if ($aColumns[$i] == "version") { /* Special output formatting for 'version' column */
            $row[] = ($aRow[$aColumns[$i]] == "0") ? '-' : $aRow[$aColumns[$i]];
        } else if ($aColumns[$i] != ' ') { /* General output */
            $row[] = $aRow[$i];
        }
    }
    $row1 = [];
    for ($j = 0; $j < count($aColumns); $j++) {
        if ($aColumns[$j] == "version") {
            $row1[] = ($aRow[$aColumns[$j]] == "0") ? '-' : $aRow[$aColumns[$j]];
        } else if ($aColumns[$j] != ' ') {
            $row1[] = $aRow[$j];
        }
    }

    $id_stock = $row[0];
    $row[0] = "<span onClick='resumenTransferencias(\"$row[2]\");'class='btn btn-primary' ><i class='fa fa-eye' ></i></span>";

    if ($row[8] == "PENDIENTE") {
        $row[8] = "<span id='$row[0]' onClick='estatus(this.id)' style='cursor:pointer; text-decoration:underline;'>PENDIENTE</span>";
    }

    //fecha  de caducidad que viene de BD
    $fechaCadu = substr($row[9], 0, 10);
    //le restamos una mes a la fecha de caducidad para poder compararla
    /* $Alertafecha = date('Y-m-d', strtotime($fechaCadu . '-1 month'));
    //sacar la fecha actual
    $now = date('Y-m-d');

    //verificamos si la fecha actual supera a la fecha de caducidad que tiene un mes restado
    if ($now > $Alertafecha) {
        $row[9] = "<span class='btn btn-danger disabled' >" . $fechaCadu . "</span>";
    } else {
        $row[9] = $fechaCadu;
    } */

    $Alertafecha0 = date('Y-m-d', strtotime($fechaCadu.'-15 day'));
    $Alertafecha = date('Y-m-d', strtotime($fechaCadu.'-6 month'));
    $Alertafecha2 = date('Y-m-d', strtotime($fechaCadu.'-11 month'));
    $Alertafecha3 = date('Y-m-d', strtotime($fechaCadu.'-12 month'));
    $now = date('Y-m-d');

    if($Alertafecha3 >= $now){
        $row[4]= "<span class='btn btn-success disabled' style='color:black;'>".$fechaCadu."</span>";
    }else if($Alertafecha >= $now && $Alertafecha2 <= $now){
        $row[4]= "<span class='btn btn-warning disabled' style='color:black;'>".$fechaCadu."</span>";
     }else if($Alertafecha0 > $now && $Alertafecha <= $now){
        $row[4]= "<span class='btn btn-danger disabled' style='color:black;'>".$fechaCadu."</span>";
    }else if($Alertafecha0 <= $now){
        $row[4]= "<span class='btn disabled' style='color:white; background-color:black'>".$fechaCadu."</span>";
    }else{
        $row[4]= "<span>".$fechaCadu."</span>";
    }

    // Se coloca la funcionalidad de abrir el reporte de entrega de la transferencia
    $folio = $row[1];

    // Consultamos la sucursal de origen //
    $query_datos_transferencia_temporal = "SELECT s.nombre_su AS sucursal_origen
                                            FROM sucursales s
                                            LEFT JOIN transferencia_temporal tt ON tt.id_sucursal_origen = s.id_su
                                            LEFT JOIN stock_has_bach shb ON shb.referencia_traspaso_temporal = tt.id_temporal AND shb.id_Producto = tt.id_producto
                                            WHERE shb.id = {$id_stock}";
    $resultado_query_sucursal_origen = mysqli_query($horizonte, $query_datos_transferencia_temporal) or die(mysqli_error($horizonte));
    $row[6] = $resultado_query_sucursal_origen->fetch_object()->sucursal_origen;

    $referencia = $row[2];
    $query_factura_compra = "SELECT nombre_factura FROM compra_factura WHERE referencia_compra = '{$referencia}'";
    $resultado_query_factura_compra = mysqli_query($horizonte, $query_factura_compra) or die(mysqli_error($horizonte));
    $class_factura = mysqli_num_rows($resultado_query_factura_compra) == 0 ? "btn-danger" : "btn-success";
    $nombre_factura = mysqli_fetch_object($resultado_query_factura_compra)->nombre_factura;
    $facturado = $class_factura == "btn-danger" ? 0 : 1;

    $query_usuario_subio_factura = "SELECT u.usuario_u AS usuario, fecha_hora FROM usuarios u LEFT JOIN compra_factura cf ON cf.id_usuario = u.id_u WHERE cf.referencia_compra = '{$referencia}'";
    $resultado_query_usuario_subio_factura = mysqli_query($horizonte, $query_usuario_subio_factura);
    $info_usuario = mysqli_fetch_object($resultado_query_usuario_subio_factura);
    $usuario_responsable = $info_usuario->usuario == "" ? $_GET['idU'] : $info_usuario->usuario;
    $fecha_hora = $info_usuario->fecha_hora;
    $row[13] = "<button type='button' onclick='verFacturaCompra(this, {$facturado}, \"{$nombre_factura}\", \"{$usuario_responsable}\", \"{$fecha_hora}\");' class='btn {$class_factura} btn-sm'><i class='fa fa-file-pdf-o' aria-hidden='true'></i></button>";

    $query_receptor = "SELECT usuario_u, DATE_FORMAT(fecha_recepcion, '%d/%m/%Y<br>%H:%i:%s') AS fecha_recepcion FROM usuarios LEFT JOIN transferencia_temporal ON transferencia_temporal.id_usuario_receptor = usuarios.id_u WHERE transferencia_temporal.id_transferencia = '{$folio}' LIMIT 1";
    $resultado_query_receptor = mysqli_query($horizonte, $query_receptor);
    $receptor = mysqli_fetch_object($resultado_query_receptor);
    $usuario_receptor = $receptor->usuario_u;
    if (empty($usuario_receptor)) {
        $row[12] = "<a role=\"button\" onclick=\"modificarReceptorTransferencia('{$folio}', this);\">PENDIENTE</a>";
        $usuario_receptor = "Sin receptor";
    } else {
        $row[12] = "<span>{$usuario_receptor}<br>{$receptor->fecha_recepcion}</span>";
    }
    $row[11] = $row[10];
    $row[1] = "<a role=\"button\" onclick=\"verReporteEntregaTransferencia('{$folio}', '{$usuario_receptor}', $_GET[idU], '{$row[7]}');\">{$folio}</a>";

    $output['aaData'][] = $row;
}

echo json_encode($output);

die();
