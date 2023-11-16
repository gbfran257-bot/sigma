<?php

require("../../../Connections/horizonte2.php");

$aColumns = array('s.id', 'c.concepto_to', 'g.nombre_generico_med', 's.existencias', 'mms.max_mm', 'mms.min_mm', 'CAST(mms.max_mm AS SIGNED) - CAST(s.existencias AS SIGNED)',);

$aTables = array('stock_has_bach s');

$sIndexColumn = "s.id";

$sJoin = 'left join conceptos c on c.id_to = s.id_Producto left join stock s1 on s1.id = s.id_stock left join usuarios u on u.id_u = s.usuario_registro left join sucursales su on su.id_su = s1.id_su left join medicamentos g on g.id_med = c.id_medicamento_g left join estatus es on es.id_est = s.estatus left join max_min_stock mms on mms.id_producto = s.id_Producto';

$resultAU = mysqli_query($horizonte, "SELECT multisucursal_u, idSucursal_u from usuarios where id_u = '$_GET[idU]'") or die(mysqli_error($horizonte));
$rowAU = mysqli_fetch_row($resultAU);
$id_suc = intval($_GET['id_sucursal']);

switch ($rowAU[0]) {
    case 0: //Solo vé lo suyo
        if (isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != '') {
            $sWhere = "WHERE (s.fecha_update BETWEEN '$_GET[min]' AND '$_GET[max]' and s.usuario_registro = '$_GET[idU]') AND (s.es_traspaso = 0 AND s.id_stock = {$id_suc})";
        } else {
            $sWhere = "where s.usuario_registro = '$_GET[idU]' AND (s.es_traspaso = 0 AND s.id_stock = {$id_suc})";
        }
        break;
    case 2: //Ve todo lo de su sucursal y lo suyo
        if (isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != '') {
            $sWhere = "WHERE (s.fecha_update BETWEEN '$_GET[min]' AND '$_GET[max]' and (s1.id_su = $id_suc or s.usuario_registro = '$_GET[idU]')) AND (s.es_traspaso = 0 AND s.id_stock = {$id_suc})";
        } else {
            $sWhere = "WHERE (s1.id_su = $id_suc or s.usuario_registro = '$_GET[idU]') AND (s.es_traspaso = 0 AND s.id_stock = {$id_suc})";
        }
        break;
    case 1: //Ve todo de todas las sucursales
        if (isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != '') {
            $sWhere = "WHERE (s.fecha_update BETWEEN '$_GET[min]' AND '$_GET[max]') AND (s.es_traspaso = 0 AND s.id_stock = {$id_suc})";
        } else {
            $sWhere = "WHERE 1 = 1 AND (s.es_traspaso = 0 AND s.id_stock = {$id_suc})";
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
$sOrder = "order by s.id desc";
if (isset($_GET['iSortCol_0'])) {
    $sOrder = "ORDER BY v.id_vc desc  ";
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
        $sWhere .= $aColumns[$i] . " LIKE '%" . mysqli_real_escape_string($gaSql['link'], $_GET['sSearch_' . $i]) . "%' ";
    }
}

/*  * SQL queries  * Get data to display */
$sQuery = "
        SELECT SQL_CALC_FOUND_ROWS " . str_replace(" , ", " ", implode(", ", $aColumns)) . "
        FROM   " . str_replace(" , ", " ", implode(", ", $aTables)) . "
		$sJoin
        $sWhere
        $sOrder
        $sLimit";

$rResult = mysqli_query($gaSql['link'], $sQuery) or die(mysqli_error($gaSql['link']));
/* echo $sQuery; */
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

    $row[0] = $hh;

    $row[6] = "<td><span onclick=\"cambiarSurtir(this);\">{$row[6]}</span></td>";

    $row[7] = "";

    $output['aaData'][] = $row;
}

echo json_encode($output);

die();
