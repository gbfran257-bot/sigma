<?php
require("../Connections/horizonte.php");
require("../funciones/php/values.php");
    /* Array of database columns which should be read and sent back to DataTables. Use a space where  * you want to insert a non-database field (for example a counter or static image) */
    
    $aColumns = array('ov.referencia_ov', 'DATE_FORMAT(ov.fecha_venta_ov,"%d/%m/%Y %H:%i")', 's.nombre_su', 'ov.gran_total_ov','ov.referencia_ov', 'ov.id_ov', 'ov.id_ov', 'ov.referencia_ov', 'ov.gran_total_ov');
    // DB tables to use 
    $aTables = array( 'orden_venta ov');
     
    // Indexed column (used for fast and accurate table cardinality) 
    $sIndexColumn = "ov.id_ov";
     
	 // Joins   
	$sJoin = 'LEFT JOIN pacientes p ON p.id_p = ov.id_paciente_ov LEFT JOIN sucursales s ON s.id_su = ov.sucursal_ov';

    //restamos x dias a la fecha en que se creo la referencia de hospital
    $fecha_minima = date('Y-m-d H:i', strtotime( $_GET['fecha_rh'] . " - 1 days"));

    //OBTENEMOS LA FECHA EN LA CUAL SE PASO LA REFERENCIA A REVISION
    mysql_select_db($database_horizonte, $horizonte);
    $result_fecha_rev = mysql_query("SELECT COUNT(id_hrh), fecha_alta_hrh FROM hist_referencias_hospital WHERE referencia_rh_hrh = '".$_GET['referencia_h']."' AND estado_hrh = 1 ORDER BY fecha_alta_hrh DESC LIMIT 1", $horizonte) or die (mysql_error());
    $datos_fecha_revision = mysql_fetch_row($result_fecha_rev);

    if($datos_fecha_revision[0]<=0){
        $sWhere = "WHERE ov.id_paciente_ov = " . $_GET['id_paciente'] . " AND ov.fecha_venta_ov" . " > '" . $fecha_minima . "' AND add_ref_hospital = 0";
    }else{
        $sWhere = "WHERE ov.id_paciente_ov = " . $_GET['id_paciente'] . " AND (ov.fecha_venta_ov BETWEEN '$fecha_minima' AND '".$datos_fecha_revision[1]."') AND add_ref_hospital = 0";
    }
	
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
    $sOrder = "ORDER BY ov.fecha_venta_ov DESC";
    if ( isset( $_GET['iSortCol_0'] ) )
    {
        $sOrder = "ORDER BY ov.fecha_venta_ov desc  ";
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
		
        $row[0] = "<div align='center'> $row[0] </div>";
        $row[1] = "<div align='left'> $row[1] </div>";
        $row[2] = "<div align='center'> $row[2] </div>";
        $row[3] = "<div align='center'> $row[3] </div>";

        //obtenemos los pagos de la referencia
        mysql_select_db($database_horizonte, $horizonte);
        $result_pagos_ov = mysql_query("SELECT SUM(pago_pag) FROM pagos_ov WHERE referencia_pag = '$row[7]'", $horizonte) or die (mysql_error());
        $datos_pagos_ov = mysql_fetch_row($result_pagos_ov);

        $row[4] = $datos_pagos_ov[0];
        $row[5] = $row[8] - $datos_pagos_ov[0];

		$output['aaData'][] = $row;
    }
    echo json_encode( $output );
?>