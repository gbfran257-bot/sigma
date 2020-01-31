<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");
    /* Array of database columns which should be read and sent back to DataTables. Use a space where  * you want to insert a non-database field (for example a counter or static image) */
	
	$aColumns = array('v.id_vc', 'e.concepto_to', 'count(v.id_vc) as suma', 'v.id_vc', 'concat(t.abreviacion_ti," ",m.nombre_u, " ", m.apaterno_u)', 'm.amaterno_u', 'sum(v.precio_vc)', 'sum(v.honorarios)', 'e.c_costo');
     
    // DB tables to use 
    $aTables = array( 'venta_conceptos v');
     
    // Indexed column (used for fast and accurate table cardinality) 
    $sIndexColumn = "v.id_vc";
     
	 // Joins   
	$sJoin = 'left join orden_venta o on o.referencia_ov = v.referencia_vc left join conceptos e on e.id_to = v.id_concepto_es left JOIN pacientes p ON p.id_p = v.id_paciente_vc left join usuarios m on m.temporal_u = e.aleatorio_c left join sucursales s on s.id_su = o.sucursal_ov left join titulos t on t.id_ti = m.id_titulo_u';
		
	$sWhere="WHERE v.fecha_venta_vc BETWEEN '$_GET[min]' AND '$_GET[max]' and  e.id_tipo_concepto_to = 1 and v.temporal_vc=0 group by e.concepto_to order by suma desc ";
	
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
        $sOrder = "ORDER BY v.id_vc desc group by e.concepto_to ";
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
	$hh=0;
    $resultT = mysql_query("SELECT count(v.id_vc) from venta_conceptos v left join conceptos e on e.id_to = v.id_concepto_es where e.id_tipo_concepto_to = 1 and v.temporal_vc=0 and v.fecha_venta_vc BETWEEN '$_GET[min]' AND '$_GET[max]'", $horizonte) or die(mysql_error());
    $rowT = mysql_fetch_row($resultT);
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
		

		
		$porce = round(($row[2]*100)/$rowT[0],4);
		
		$row[3] = "<span>$porce %</span>";
		
		$row[4] = "<span>$row[4] $row[5]</span>";
	    $row[5] = $row[6];
        $row[6] = $row[7];
        $row[7] = $row[8]*$row[2];
        $row[8] = $row[5] - $row[6] - $row[7];
		$output['aaData'][] = $row;
    }
    echo json_encode( $output );
?>
