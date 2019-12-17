<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");
    /* Array of database columns which should be read and sent back to DataTables. Use a space where * you want to insert a non-database field (for example a counter or static image) */
	$id_vc = sqlValue($_GET['id_vc'], "int");
	
	$aColumns = array('r.id_rl', 'b.base_b', 'r.id_rl', 'r.id_rl', 'r.id_rl', 'concat(r.r_valor_texto," ", r.valor_texto_rl)');
     
    // DB tables to use 
    $aTables = array( 'resultados_laboratorio r');
     
    // Indexed column (used for fast and accurate table cardinality) 
    $sIndexColumn = "r.id_rl";
     
	 // Joins   
	$sJoin = 'left JOIN bases b on b.id_b = r.id_base_rl';
	
	$sWhere = "WHERE r.id_estudio_vc_rl = $id_vc and r.boleano_rl = 1 ";
	
    /* Database connection information */
    $gaSql['user'] = $username_horizonte; $gaSql['password'] = $password_horizonte; $gaSql['db'] = $database_horizonte; 
	$gaSql['server'] = $hostname_horizonte;
     
    $gaSql['link'] =  mysql_pconnect( $gaSql['server'], $gaSql['user'], $gaSql['password']  ) or die( 'Could not open connection to server' );
     
    mysql_select_db( $gaSql['db'], $gaSql['link'] ) or die( 'Could not select database '. $gaSql['db'] );
     
    /*  * Paging */
    $sLimit = "";
    if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
    {
        $sLimit = "LIMIT ".mysql_real_escape_string( $_GET['iDisplayStart'] ).", ".
            mysql_real_escape_string( $_GET['iDisplayLength'] );
    }
     
    /* * Ordering */
    $sOrder = "ORDER BY r.id_rl desc";
    if ( isset( $_GET['iSortCol_0'] ) )
    {
        $sOrder = "ORDER BY ";
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
     
    /* * Output */
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
		$row1 = array();
        for ( $j=0 ; $j<count($aColumns) ; $j++ )
        {
            if ( $aColumns[$j] == "version" ) { $row1[] = ($aRow[ $aColumns[$j] ]=="0") ? '-' : $aRow[ $aColumns[$j] ]; }
            else if ( $aColumns[$j] != ' ' ) { $row1[] = $aRow[$j]; }
        }
		$nameMi = explode("_MIORG", $row[1]);
		
		$row[0]=$hh; $row[1] = $nameMi[0]; $mi_valor = sqlValue($row[5], "text");
		//$nombreP = '"'.$row[1].'"'; $nombreEstu = '"'.$row[3].'"'; $referenciaE = '"'.$row[2].'"';
		$opcion1 = ''; $opcion2 = ''; $opcion3 = ''; $opcion4 = '';
		if($row[5]=='ESCASA'){$opcion1 = 'selected';}
		else if($row[5]=='ESCASA CANTIDAD'){$opcion2 = 'selected';}
		else if($row[5]=='MEDIANA CANTIDAD'){$opcion3 = 'selected';}
		else if($row[5]=='ALTA CANTIDAD'){$opcion4 = 'selected';}
		else{$opcion1 = 'selected';}
		
		$row[2] = "<div style='white-space:nowrap;'>$row[5]</div>";
				
		$row[3] = "<div align='center'><button type='button' class='btn btn-danger btn-xs' id='tbn-quitar_moa' onClick='quitar_moa($row[4]);'><i class='fa fa-trash'></i></button></div>";
		
		$output['aaData'][] = $row;
    }
     
    echo json_encode( $output );
?>