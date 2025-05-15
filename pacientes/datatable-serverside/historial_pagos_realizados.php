<?php
require("../../Connections/horizonte.php");
require_once("../../funciones/php/values.php");

	$referencia = sqlValue($_GET['referencia'], "text");
	$aColumns = array('p.id_pag', 'p.referencia_pag', 'p.pago_pag', 'p.id_pag', 'DATE_FORMAT(p.fecha_pag,"%d/%m/%Y")', 'cfp.forma_pago_fp', 'd.nombre_d', 'p.id_pag');
     
    // DB tables to use
    $aTables = array( 'pagos_ov p');
     
    // Indexed column (used for fast and accurate table cardinality) 
    $sIndexColumn = "p.id_pag";
     
	 // Joins   hasta aqui
	$sJoin = 'LEFT JOIN departamentos d ON d.id_d = p.departamento_pa LEFT JOIN catalogo_forma_pago cfp ON cfp.id_fp = p.forma_pago_pag';
	 
    // CONDITIONS
    $sWhere = "WHERE referencia_pag = $referencia";
	 
    /* Database connection information */
    $gaSql['user']       = $username_horizonte;
    $gaSql['password']   = $password_horizonte;
    $gaSql['db']         = $database_horizonte;
    $gaSql['server']     = $hostname_horizonte;
     
    $gaSql['link'] =  mysql_pconnect( $gaSql['server'], $gaSql['user'], $gaSql['password']  ) or
        die( 'Could not open connection to server' );
     
    mysql_select_db( $gaSql['db'], $gaSql['link'] ) or 
        die( 'Could not select database '. $gaSql['db'] );
     
    /*  * Paging */
    $sLimit = "";
    if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
    {
        $sLimit = "LIMIT ".mysql_real_escape_string( $_GET['iDisplayStart'] ).", ".
            mysql_real_escape_string( $_GET['iDisplayLength'] );
    }
     
    /* * Ordering  */
    $sOrder = "";
    if ( isset( $_GET['iSortCol_0'] ) )
    {
        $sOrder = "ORDER BY";
        for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
        {
            if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
            {
                $sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
                    ".mysql_real_escape_string( $_GET['sSortDir_'.$i] ) .", ";
            }
        }
         
        $sOrder = substr_replace( $sOrder, "", -2 );
        if ( $sOrder == "ORDER BY" ) { $sOrder = ""; }
    }
     
    /* 
     * Filtering
     * NOTE this does not match the built-in DataTables filtering which does it
     * word by word on any field. It's possible to do here, but concerned about efficiency
     * on very large tables, and MySQL's regex functionality is very limited
    */
 
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
            if ( $sWhere == "" ) { $sWhere = "WHERE "; }
            else{ $sWhere .= " AND "; }
            $sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
        }
    }
     
    /* * SQL queries * Get data to display  */
    $sQuery = "
        SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
        FROM   ".str_replace(" , ", " ", implode(", ", $aTables))."
		$sJoin
        $sWhere
        $sOrder
        $sLimit";
     //echo $sQuery;
    $rResult = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
     
    /* Data set length after filtering */
    $sQuery = "SELECT FOUND_ROWS()";
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
     
    /* * Output */
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
        {
            if ( $aColumns[$i] == "version" ) { $row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ]; }
            else if ( $aColumns[$i] != ' ' ) { $row[] = $aRow[$i]; }			
        }
		$row1 = array();
        for ( $j=0 ; $j<count($aColumns) ; $j++ )
        {
            if ( $aColumns[$j] == "version" ) { $row1[] = ($aRow[ $aColumns[$j] ]=="0") ? '-' : $aRow[ $aColumns[$j] ]; }
            else if ( $aColumns[$j] != ' ' ) { $row1[] = $aRow[$j]; }
        }
		
		/* mysql_select_db($database_horizonte, $horizonte); 
		$resultTabo = mysql_query("SELECT sum(pago_pag) from pagos_ov where referencia_pag = '$row[2]'", $horizonte) or die(mysql_error()); 
		$rowTabo = mysql_fetch_row($resultTabo); */

        $row[2] = "<div style='display: flex; align-items: center;'><input type='number' class='form-control input-sm' value='$row[2]' style='width:100px; text-align:right;' id='abono_$row[0]' placeholder='abono' min=0.001></div>";
        $row[3] = "<div><input type='text' class='form-control input-sm' style='width:150px; text-align:left;' id='motivo_$row[0]' placeholder='Motivo de modificacion'></div>";
        $row[7] = "<div><button onclick='modificarAbono($row[0]);' class='btn btn-info btn-xs' title=''><i class='fa fa-floppy-o' aria-hidden='true'></i></button></div>";
				
		$output['aaData'][] = $row;
		
    }
    echo json_encode( $output );
?>
