<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");
    /* Array of database columns which should be read and sent back to DataTables. Use a space where  * you want to insert a non-database field (for example a counter or static image) */
	
	$aColumns = array('vc.id_personal_medico_vc', 'CONCAT_WS(" ", t.abreviacion_ti, u.nombre_u, u.apaterno_u, u.amaterno_u)', 'COUNT(vc.id_personal_medico_vc)', "(SELECT (COALESCE(SUM(vc1.precio_vc), 0) - COALESCE(SUM(vc1.descuento), 0)) FROM venta_conceptos vc1 LEFT JOIN conceptos c1 ON c1.id_to = vc1.id_concepto_es WHERE c1.id_tipo_concepto_to IN (1,2) AND vc1.id_personal_medico_vc = vc.id_personal_medico_vc AND (vc1.fecha_venta_vc BETWEEN '$_GET[min]' AND '$_GET[max]') AND vc1.referencia_vc IS NOT NULL)", "(SELECT (COALESCE(SUM(vc1.precio_vc), 0) - COALESCE(SUM(vc1.descuento), 0)) FROM venta_conceptos vc1 LEFT JOIN conceptos c1 ON c1.id_to = vc1.id_concepto_es WHERE c1.id_tipo_concepto_to IN (4) AND vc1.id_personal_medico_vc = vc.id_personal_medico_vc AND (vc1.fecha_venta_vc BETWEEN '$_GET[min]' AND '$_GET[max]') AND vc1.referencia_vc IS NOT NULL)", "(SELECT (COALESCE(SUM(vc1.precio_vc), 0) - COALESCE(SUM(vc1.descuento), 0)) FROM venta_conceptos vc1 LEFT JOIN conceptos c1 ON c1.id_to = vc1.id_concepto_es WHERE c1.id_tipo_concepto_to IN (3) AND vc1.id_personal_medico_vc = vc.id_personal_medico_vc AND (vc1.fecha_venta_vc BETWEEN '$_GET[min]' AND '$_GET[max]') AND vc1.referencia_vc IS NOT NULL)", "(SELECT COALESCE(SUM(vc1.precio_vc), 0) FROM venta_conceptos vc1 WHERE vc1.id_personal_medico_vc = vc.id_personal_medico_vc AND (vc1.fecha_venta_vc BETWEEN '$_GET[min]' AND '$_GET[max]') AND vc1.referencia_vc IS NOT NULL)", "(SELECT COALESCE(SUM(vc1.descuento), 0) FROM venta_conceptos vc1 WHERE vc1.id_personal_medico_vc = vc.id_personal_medico_vc AND (vc1.fecha_venta_vc BETWEEN '$_GET[min]' AND '$_GET[max]') AND vc1.referencia_vc IS NOT NULL)");
     
    // DB tables to use 
    $aTables = array( 'venta_conceptos vc');
     
    // Indexed column (used for fast and accurate table cardinality) 
    $sIndexColumn = "vc.id_vc";
     
	 // Joins   
	$sJoin = 'LEFT JOIN usuarios u ON u.id_u = vc.id_personal_medico_vc LEFT JOIN catalogo_puestos cp on cp.id_cp = u.idPuesto_u LEFT JOIN titulos t on t.id_ti = u.id_titulo_u';
		
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
	$sWhere.=" (vc.fecha_venta_vc BETWEEN '$_GET[min]' AND '$_GET[max]') AND vc.referencia_vc IS NOT NULL AND vc.id_personal_medico_vc NOT IN(0) GROUP BY vc.id_personal_medico_vc ORDER BY u.nombre_u ASC";
	
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
        $sOrder = "GROUP BY vc.id_personal_medico_vc ORDER BY u.nombre_u ASC ";
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
        // echo $sQuery;

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


	/* $hh=0;
    $resultT = mysql_query("SELECT count(v.id_vc) from venta_conceptos v left join conceptos e on e.id_to = v.id_concepto_es where e.id_tipo_concepto_to = 1 and v.temporal_vc=0 and v.fecha_venta_vc BETWEEN '$_GET[min]' AND '$_GET[max]'", $horizonte) or die(mysql_error());
    $rowT = mysql_fetch_row($resultT);
    $resultT1 = mysql_query("SELECT count(v.id_vc) from venta_conceptos v left join conceptos e on e.id_to = v.id_concepto_es where e.id_tipo_concepto_to = 1 and v.temporal_vc=0 and estatus_vc = 6 and v.fecha_venta_vc BETWEEN '$_GET[min]' AND '$_GET[max]'", $horizonte) or die(mysql_error());
    $rowT1 = mysql_fetch_row($resultT1);
    $contV1 =0; */
    while ( $aRow = mysql_fetch_array( $rResult ) )
    {
		$hh++;
        $row = array();
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        { if ( $aColumns[$i] == "version" ) { /* Special output formatting for 'version' column */ $row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ]; } else if ( $aColumns[$i] != ' ' ) { /* General output */ $row[] = $aRow[$i]; } }
		$row1 = array();
        for ( $j=0 ; $j<count($aColumns) ; $j++ ) { if ( $aColumns[$j] == "version" ) { $row1[] = ($aRow[ $aColumns[$j] ]=="0") ? '-' : $aRow[ $aColumns[$j] ]; } else if ( $aColumns[$j] != ' ' ) { $row1[] = $aRow[$j]; } }

		/* $row[0] = "<span>$hh</span>";
		mysql_select_db($database_horizonte, $horizonte);
		$suma = $row[2];
		$porce = round(($suma*100)/$rowT[0],1);
		$row[3] = "<span>$porce %</span>";
	    $row[5] = $row[6];
        $row[6] = $row[4] - $row[5];
        $row[9] = $row[2];
        $row[2] = "<span class='btn btn-primary' onclick='verOV($row[8],\"$_GET[min]\",\"$_GET[max]\",\"$row[1]\")'>$row[2]</span>";
        $contV1++; */

        $row[2] = "<button type='button' class='btn btn-primary btn-sm' onclick='verConceptos($row[0], \"$row[1]\");'>$row[2]</button>";

		$output['aaData'][] = $row;
    }
    echo json_encode( $output );
?>
