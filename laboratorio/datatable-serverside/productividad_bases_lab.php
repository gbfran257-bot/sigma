<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");
    /* Array of database columns which should be read and sent back to DataTables. Use a space where  * you want to insert a non-database field (for example a counter or static image) */
	
	$aColumns = array('v.id_vc', 'b.base_b', 'COUNT(b.id_b) AS suma','v.id_vc','b.precio_maquila_b','ac.cantidad_ac','a.nombre_a','u.unidad_un','b.id_b' );
     
    // DB tables to use 
    $aTables = array( 'venta_conceptos v');
     
    // Indexed column (used for fast and accurate table cardinality) 
    $sIndexColumn = "v.id_vc";
     
	 // Joins   
	$sJoin = 'left join conceptos e on e.id_to = v.id_concepto_es LEFT JOIN asignar_bases ab ON ab.id_estudio_ab = e.id_to left JOIN bases b ON b.id_b = ab.id_base_ab left join areas a on a.id_a = b.id_area_b left join asignar_consumibles ac on ac.aleatorio_ac = b.aleatorio_b left join unidades u on u.id_un = b.unidad_medida_r_b';
		
	$sWhere="WHERE v.fecha_venta_vc BETWEEN '$_GET[min]' AND '$_GET[max]' and e.id_tipo_concepto_to = 3 and v.temporal_vc=0";

    
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
        $sOrder = "ORDER BY suma desc group by b.base_b ";
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

    $sWhere .= " GROUP BY b.base_b ORDER BY suma desc ";
     
    /*  * SQL queries  * Get data to display */
    $sQuery = "
        SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
        FROM   ".str_replace(" , ", " ", implode(", ", $aTables))."
		$sJoin
        $sWhere
        $sOrder
        $sLimit";

    //$sQuery.'---------------------------------------.'.$sWhere;
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

    $resultT = mysql_query("SELECT COUNT(b.id_b) FROM venta_conceptos v left join conceptos e on e.id_to = v.id_concepto_es LEFT JOIN asignar_bases ab ON ab.id_estudio_ab = e.id_to left JOIN bases b ON b.id_b = ab.id_base_ab where e.id_tipo_concepto_to = 3 and v.temporal_vc=0 and v.fecha_venta_vc BETWEEN '$_GET[min]' AND '$_GET[max]' ", $horizonte) or die(mysql_error());
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
        $row[1] = "<span style='text-decoration:underline; cursor:pointer;' onclick='ver_estudios($row[8])'>$row[1]</span>";
        $porce = round(($row[2]*100)/$rowT[0],4);
		$row[3] = "<span>$porce %</span>";
        $row[4] = $row[4] * $row[2];
        $row[5] = ($row[5] * $row[2]) . " " . $row[7];

       /*  $resultPr = mysql_query("SELECT sum(b.precio_maquila_b) from asignar_bases ab ".
            "left join bases b on b.id_b = ab.id_base_ab where ab.aleatorio_ab='$row[4]'", $horizonte) or die(mysql_error());
        $rowPr = mysql_fetch_row($resultPr);
		
		$porce = round(($row[2]*100)/$rowT[0],4);
		
		$row[3] = "<span>$porce %</span>";
        $row[4] = $row[6];
        $total = $row[6];
        $costo = ($rowPr[0]+$row[5])*$row[2];
        $utilidad = $total - $costo;
        $row[5] = $costo;
        $row[6] = $utilidad; */
				
		$output['aaData'][] = $row;
    }
    echo json_encode( $output );
?>
