<?php
require("../../Connections/horizonte.php");
	$aColumns = array('dx.id_dxc', 'd.clave_di', 'd.nombre_di','dx.id_dxc', 'dx.id_dxc', 'dx.id_dxc', 'dx.id_dxc', 'dx.primario_dxc', 'dx.id_c_dxc','d.pdf');
     
    // DB tables to use 
    $aTables = array( 'dx_consultas dx');
     
    // Indexed column (used for fast and accurate table cardinality) 
    $sIndexColumn = "dx.id_dxc";
     
	 // Joins   
	$sJoin = 'left join diagnosticos d on d.id_di = dx.id_dx_dxc ';
	 
    // CONDITIONS 
    $sWhere = "WHERE dx.id_c_dxc = '$_GET[idC]' ";

    /* Database connection information */
    $gaSql['user']       = $username_horizonte;
    $gaSql['password']   = $password_horizonte;
    $gaSql['db']         = $database_horizonte;
    $gaSql['server']     = $hostname_horizonte;
 
     
    $gaSql['link'] =  mysql_pconnect( $gaSql['server'], $gaSql['user'], $gaSql['password']  ) or
        die( 'Could not open connection to server' );
     
    mysql_select_db( $gaSql['db'], $gaSql['link'] ) or 
        die( 'Could not select database '. $gaSql['db'] );
     
    /*  * Paging  */
    $sLimit = "";
    if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
    {
        $sLimit = "LIMIT ".mysql_real_escape_string( $_GET['iDisplayStart'] ).", ".
            mysql_real_escape_string( $_GET['iDisplayLength'] );
    }
     
    /* * Ordering */
    $sOrder = "";
    if ( isset( $_GET['iSortCol_0'] ) )
    {
        $sOrder = "ORDER BY  ";
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
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        {
            $sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
        }
        $sWhere = substr_replace( $sWhere, "", -3 );
        $sWhere .= ')';
    }
     
    /* Individual column filtering */
    for ( $i=0 ; $i<count($aColumns) ; $i++ )
    {
        if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
        {
            if ( $sWhere == "" ) { $sWhere = "WHERE "; }
            else { $sWhere .= " AND "; }
            $sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
        }
    }
     
    /* * SQL queries * Get data to display */
    $sQuery = "
        SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
        FROM   ".str_replace(" , ", " ", implode(", ", $aTables))."
		$sJoin
        $sWhere
        $sOrder
        $sLimit";
     
    $rResult = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
     
    /* Data set length after filtering */
    $sQuery = "
        SELECT FOUND_ROWS()
    ";
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
     
    /* * Output  */
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
        {
            if ( $aColumns[$i] == "version" ) { $row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ]; }
            else if ( $aColumns[$i] != ' ' ) { $row[] = $aRow[$i]; }
        }
		$row[0]=$hh;
		$row[5] = "<div align='center'><button onClick='borrarDX(this.id,this.lang);' id='$row[6]' lang='$row[8]' type='button' class='btn btn-danger btn-xs'><i class='fa fa-trash' aria-hidden='true' alt='Borrar diagnóstico'></i></button></div>";
		
		if($row[7]==1){
			$row[3] = "<div align='center'><button type='button' class='btn btn-success btn-xs dx_prim'><i class='fa fa-check' aria-hidden='true' alt='Diagnóstico primario'></i></button></div>";
		}else{
			$row[3] = "<div align='center'><button onClick='dxPrimario(this.id,this.lang);' id='$row[6]' lang='$row[8]' type='button' class='btn btn-warning btn-xs dx_prim'><i class='fa fa-refresh' aria-hidden='true' alt='Diagnóstico secundario'></i></button></div>";
		}

        if($row[9] != ''){
            $url = "catalogos/diagnosticos/documentos/".$row[9];
            $row[4] = "<div align='center'><a href='$url' target='_blank' class='btn btn-primary btn-xs dx_prim'><i class='fa fa-file-text' aria-hidden='true' alt=''></i></button></div>";
        }else{
            $row[4] = "<div align='center'><button type='button' class='btn btn-primary btn-xs dx_prim' disabled='true'><i class='fa fa-file-text' aria-hidden='true' alt=''></i></button></div>";
        }
		
		$output['aaData'][] = $row;
    }
    echo json_encode( $output );
?>