<?php
require("../Connections/horizonte.php");
require("../funciones/php/values.php");
    /* Array of database columns which should be read and sent back to DataTables. Use a space where  * you want to insert a non-database field (for example a counter or static image) */
	
    
    $aColumns = array('vc.contador_vc', 'tc.tipo_concepto_tc', 'c.concepto_to', 'tc.tipo_concepto_tc', 'concat(vc.referencia_vc,"/",contador_vc)', 
    'vc.estatus_vc', 'vc.precio_vc','id_personal_medico_vc', 'e.estatus_est', 'vc.id_vc', 'c.id_departamento_to', 'vc.id_vc', 'vc.referencia_vc',
    'motivo_c_ov', 'observaciones_i_ov', 'observaciones_l_ov', 'observaciones_s_ov', 'motivo_desc_c_ov', 'motivo_desc_i_ov', 'motivo_desc_l_ov', 'motivo_desc_s_ov', 'motivo_desc_f_ov');
    
    $aTables = array( 'venta_conceptos vc');
     
    // Indexed column (used for fast and accurate table cardinality) 
    $sIndexColumn = "vc.id_vc";
     
	 // Joins   
	$sJoin = 'left join orden_venta ov on ov.referencia_ov = vc.referencia_vc left join estatus e on e.id_est = vc.estatus_vc left join conceptos c on c.id_to = vc.id_concepto_es left join catalogo_tipo_conceptos tc on tc.id_tc = c.id_tipo_concepto_to LEFT JOIN rel_referencias_hospital rel ON rel.referencia_rrh = ov.referencia_ov ';

	
	$sWhere = "where rel.id_rh_rrh = " . $_GET['id_rh'] . " AND (ov.fecha_venta_ov BETWEEN '" . $_GET['min'] . "' AND '" . $_GET['max'] . "')";

	
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
    $sOrder = "ORDER BY c.id_tipo_concepto_to ASC ";
    if ( isset( $_GET['iSortCol_0'] ) )
    {
        /* $sOrder = "ORDER BY arh.fecha_arh DESC  "; */
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
     
    /* Individual column filtering */
    for ( $i=0 ; $i<count($aColumns) ; $i++ )
    {
        if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
        {
            if ( $sWhere == "" ) { $sWhere = "WHERE "; } else { $sWhere .= " AND "; }
            $sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
        }
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

    while ( $aRow = mysql_fetch_array( $rResult ) )
    {
        $row = array();
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        { if ( $aColumns[$i] == "version" ) { /* Special output formatting for 'version' column */ $row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ]; } else if ( $aColumns[$i] != ' ' ) { /* General output */ $row[] = $aRow[$i]; } }
		$row1 = array();
        for ( $j=0 ; $j<count($aColumns) ; $j++ ) { if ( $aColumns[$j] == "version" ) { $row1[] = ($aRow[ $aColumns[$j] ]=="0") ? '-' : $aRow[ $aColumns[$j] ]; } else if ( $aColumns[$j] != ' ' ) { $row1[] = $aRow[$j]; } }
		

        $row[0] = "<div align='center'> $row[12] </div>";
        $row[1] = "<div align='center'> $row[1] </div>";
        $row[2] = "<div align='center'> $row[2] </div>";
        $row[3] = "<div align='center'> $row[3] </div>";
        $row[4] = "<div align='center'> $row[6] </div>";
        // $row[4] = "<div align='center'><button type='button' class='btn btn-xs btn-warning' onClick='borrarRef(this.id,$row[5]);' id='$row[4]'><i class='fa fa-chain-broken' aria-hidden='true'></i></button></div>";

		$output['aaData'][] = $row;
    }
    echo json_encode( $output );
?>
