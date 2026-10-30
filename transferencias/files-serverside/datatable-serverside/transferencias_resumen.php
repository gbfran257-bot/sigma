<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");
    /* Array of database columns which should be read and sent back to DataTables. Use a space where  * you want to insert a non-database field (for example a counter or static image) */
	
	$aColumns = array('tt.id_transferencia', 'tt.id_transferencia', 'm.nombre_generico_med', 'c.concepto_to', 'tt.cantidad_transferir', 'tt.lote', 'tt.caducidad', 's.nombre_su', 's1.nombre_su', 'tt.id_stock_has_bach', 'u1.usuario_u', 'tt.id_usuario_transferencia', 'u.usuario_u', 'CONCAT_WS("<br>", u.usuario_u, DATE_FORMAT(tt.fecha_transferencia,"%d/%m/%Y"), DATE_FORMAT(tt.fecha_transferencia,"%H:%i:%s"))', 'tt.id_usuario_receptor');
     
    // DB tables to use 
    $aTables = array( 'transferencia_temporal tt');
     
    // Indexed column (used for fast and accurate table cardinality) 
    $sIndexColumn = "tt.id_transferencia";
     
	 // Joins   
	$sJoin = 'left join conceptos c on c.id_to = tt.id_producto left join medicamentos m on m.id_med = c.id_medicamento_g left join sucursales s on s.id_su = tt.id_sucursal_origen left join sucursales s1 on s1.id_su = tt.id_sucursal_destino left join usuarios u on u.id_u = tt.id_usuario_transferencia left join usuarios u1 on u1.id_u = tt.id_usuario_receptor';

    $sWhere="";

    /* Individual column filtering */
    for ( $i=0 ; $i<count($aColumns) ; $i++ )
    {
        if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
        {
            if ( $sWhere == "" ) { $sWhere = "WHERE "; } else { $sWhere .= " AND "; }
            $sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
        }
    }
    if ( $sWhere == "" ) { $sWhere = "WHERE "; } else { $sWhere .= " AND "; }
	$sWhere.=" transf_valida = 1 AND tt.id_usuario_receptor NOT IN(0) AND tt.fecha_transferencia BETWEEN '$_GET[min]' AND '$_GET[max]' ";
	
    /* Database connection information */
    $gaSql['user']       = $username_horizonte;
    $gaSql['password']   = $password_horizonte;
    $gaSql['db']         = $database_horizonte;
    $gaSql['server']     = $hostname_horizonte;
 
    $gaSql['link'] =  mysql_pconnect( $gaSql['server'], $gaSql['user'], $gaSql['password']  ) or die( 'Could not open connection to server' );
     
    mysql_select_db( $gaSql['db'], $gaSql['link'] ) or die( 'Could not select database '. $gaSql['db'] );
     
    /*  * Paging */
    $sLimit = "";
    if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' ) { $sLimit = "LIMIT ".mysql_real_escape_string( $_GET['iDisplayStart'] ).", ". mysql_real_escape_string( $_GET['iDisplayLength'] ); }
     
    /* * Ordering */
    $sOrder = "";
    if ( isset( $_GET['iSortCol_0'] ) )
    {
        $sOrder = "ORDER BY ";
        for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ ) { if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" ) { $sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".mysql_real_escape_string( $_GET['sSortDir_'.$i] ) .", "; } }
         
        $sOrder = substr_replace( $sOrder, "", -2 );
        if ( $sOrder == "ORDER BY" ) { $sOrder = ""; }
    }
     
    /*  * Filtering * NOTE this does not match the built-in DataTables filtering which does it * word by word on any field. It's possible to do here, but concerned about efficiency * on very large tables, and MySQL's regex functionality is very limited */
 
    if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
    {
        $sWhere .= "AND (";
        for ( $i=0 ; $i<count($aColumns) ; $i++ ) { $sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR "; }
        $sWhere = substr_replace( $sWhere, "", -3 );
        $sWhere .= ')';
    }
     
  
     
    /*  * SQL queries  * Get data to display */
    $sQuery = "
        SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
        FROM   ".str_replace(" , ", " ", implode(", ", $aTables))."
		$sJoin
        $sWhere
        $sOrder
        $sLimit";

    $rResult = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
     
    /* Data set length after filtering */
    $sQuery = " SELECT FOUND_ROWS() ";
    $rResultFilterTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
    $aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
    $iFilteredTotal = $aResultFilterTotal[0];
     
    /* Total data set length */
    $sQuery = "
        SELECT COUNT(".$sIndexColumn.")
        FROM   ".$aTables[0];
     
    $rResultTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
    $aResultTotal = mysql_fetch_array($rResultTotal);
    $iTotal = $aResultTotal[0];
     
    /*  * Output */
    $output = array(
        "sEcho" => intval($_GET['sEcho']),
        "iTotalRecords" => $iTotal,
        "iTotalDisplayRecords" => $iFilteredTotal,
        "aaData" => array()
    );
	$hh=0;
     
    while ( $aRow = mysql_fetch_array( $rResult ) )
    {
		$hh++;
        $row = array();
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        { if ( $aColumns[$i] == "version" ) { /* Special output formatting for 'version' column */ $row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ]; } else if ( $aColumns[$i] != ' ' ) { /* General output */ $row[] = $aRow[$i]; } }
		$row1 = array();
        for ( $j=0 ; $j<count($aColumns) ; $j++ ) { if ( $aColumns[$j] == "version" ) { $row1[] = ($aRow[ $aColumns[$j] ]=="0") ? '-' : $aRow[ $aColumns[$j] ]; } else if ( $aColumns[$j] != ' ' ) { $row1[] = $aRow[$j]; } }
		
		$row[0] = "<span>$hh</span>";

        mysql_select_db($database_horizonte, $horizonte);
        $query_nombre_receptor = mysql_query("SELECT CONCAT_WS(' ', nombre_u, apaterno_u) FROM usuarios WHERE id_u = $row[14]", $horizonte) or die (mysql_error());
        $nombreReceptor = mysql_fetch_row($query_nombre_receptor);
        $usuario_receptor = $nombreReceptor[0];

        mysql_select_db($database_horizonte, $horizonte);
        $query_factura_compra = mysql_query("SELECT nombre_factura FROM compra_factura WHERE referencia_compra = (SELECT referencia_compra FROM stock_has_bach WHERE id = $row[9])", $horizonte) or die (mysql_error());
        $datosFactC = mysql_fetch_row($query_factura_compra);
        
        if($datosFactC[0] == ''){
            $class_factura = "btn-danger";
        }else{
            $class_factura = "btn-success";
        }

        $nombre_factura = $datosFactC[0];
        $facturado = $class_factura == "btn-danger" ? 0 : 1;

        mysql_select_db($database_horizonte, $horizonte);
        $query_usuario_subio_factura = mysql_query("SELECT u.usuario_u, fecha_hora FROM usuarios u LEFT JOIN compra_factura cf ON cf.id_usuario = u.id_u WHERE cf.referencia_compra = (SELECT referencia_compra FROM stock_has_bach WHERE id = $row[9])", $horizonte) or die (mysql_error());
        $datosFactU = mysql_fetch_row($query_usuario_subio_factura);
        $usuario_responsable = $datosFactU[0];
        $fecha_hora = $datosFactU[1];
        
        $row[9] = "<button type='button' onclick='verFacturaCompra(this, {$facturado}, \"{$nombre_factura}\", \"{$usuario_responsable}\", \"{$fecha_hora}\");' class='btn {$class_factura} btn-sm'><i class='fa fa-file-pdf-o' aria-hidden='true'></i></button>";
		
        $row[1] = "<a role=\"button\" onclick=\"verReporteEntregaTransferencia('$row[1]', '$usuario_receptor', $row[14], '$row[13]');\">$row[1]</a>";

		$output['aaData'][] = $row;
    }
    echo json_encode( $output );
?>
