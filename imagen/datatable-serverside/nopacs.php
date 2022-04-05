<?php
require("../../Connections/ipacs.php");
	$aColumns = array('p.created_time', 'family_name', 'sq.mods_in_study', 'p.pat_id', 'given_name', 'middle_name', 'name_prefix', 'p.pk' );
     
    // DB tables to use 
    $aTables = array( 'patient p');
     
    // Indexed column (used for fast and accurate table cardinality) 
    $sIndexColumn = "p.pk";
     
	 // Joins   
	$sJoin = 'inner join person_name pe on pe.pk=p.pat_name_fk '.
             'left join study s on s.patient_fk = p.pk '.
             'left join study_query_attrs sq on sq.study_fk = s.pk ';
	 
    // CONDITIONS
	//if(isset($_GET['min']) && $_GET['min'] != ''){} idPacs
    $sWhere = "WHERE 1=1 " ;

    /* Database connection information */
    $gaSql['user']       = $username_ipacs;
    $gaSql['password']   = $password_ipacs;
    $gaSql['db']         = $database_ipacs;
    $gaSql['server']     = $hostname_ipacs;
     
    $gaSql['link'] =  $ipacs;
     
    //mysql_select_db( $gaSql['db'], $gaSql['link'] );
	/*mysql_query("SET character_set_client=utf8", $gaSql['link']);
	mysql_query("SET character_set_connection=utf8", $gaSql['link']);
	mysql_query("SET character_set_results=utf8", $gaSql['link']);*/
     
    /*  * Paging */
    $sLimit = "";
    if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
    {
        $sLimit = "LIMIT 30";
    }
     
    /* * Ordering */
    $sOrder = "GROUP BY p.pk, s.pk, sq.pk, pe.pk order by p.created_time desc";
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
		$sOrder = "group by p.pk, s.pk, sq.pk, pe.pk order by p.created_time desc";
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
            $sWhere .= $aColumns[$i]." LIKE '%".( $_GET['sSearch'] )."%' OR ";
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

            if($i == 1){
                $sWhere .= "(".$aColumns[$i]." LIKE '".($_GET['sSearch_'.$i])."%' or ".$aColumns[4]." LIKE '%".($_GET['sSearch_'.$i])."%' or ".$aColumns[5]." LIKE '%".($_GET['sSearch_'.$i])."%' or ".$aColumns[6]." LIKE '%".($_GET['sSearch_'.$i])."%') ";
            }else{
                $sWhere .= $aColumns[$i]." LIKE '%".($_GET['sSearch_'.$i])."%' ";
            }
        }
    }
     
    /* * SQL queries * Get data to display */
    $sQuery = "
        SELECT ".str_replace(" , ", " ", implode(", ", $aColumns))."
        FROM   ".str_replace(" , ", " ", implode(", ", $aTables))."
		$sJoin
        $sWhere
        $sOrder
        $sLimit";
     
    //$rResult = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
    $rResult = pg_query($ipacs, $sQuery);
    //echo $sQuery;
    /* Data set length after filtering */
    /*$sQuery = "
        SELECT FOUND_ROWS()
    ";*/
    //$rResultFilterTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
    //$rResultFilterTotal = pg_query($ipacs, $sQuery);
    $aResultFilterTotal = pg_num_rows( $rResult );
    $iFilteredTotal = $aResultFilterTotal;//[0];
    
    /* Total data set length */
    $sQuery = "
        SELECT COUNT(".$sIndexColumn.")
        FROM   ".$aTables[0];
     
    //$rResultTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
    $rResultTotal = pg_query($ipacs, $sQuery);
    $aResultTotal = pg_fetch_array($rResultTotal);
    $iTotal = $aResultTotal[0];
     
    /* * Output */
    $output = array(
        "sEcho" => intval($_GET['sEcho']),
        "iTotalRecords" => $iTotal,
        "iTotalDisplayRecords" => $iFilteredTotal,
        "aaData" => array()
    );
	$hh=0;
     
    while ( $aRow = pg_fetch_array( $rResult ) )
    {
		$hh++;
        $row = array();
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        {
            if ( $aColumns[$i] == "version" ) { $row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ]; }
            else if ( $aColumns[$i] != ' ' ) { $row[] = $aRow[$i]; }
			
        }
		
		//mysql_select_db($database_ipacs, $ipacs);
		//$resultTC = pg_query($ipacs, "SELECT concat(family_name, ' ', given_name, ' ', middle_name, ' ', name_prefix) from person_name WHERE pk = $row[4] ");

		//$rowTC = mysql_fetch_row($resultTC);
        //$rowTC = pg_fetch_row($resultTC);
		
		//$row[1] = $rowTC[0];
        $row[1] = $row[5]." ".$row[6]." ".$row[1]." ".$row[4];
		$row[0] = "<div lang='$row[7]'>".date("d-m-Y H:i", strtotime($row[0]))."</div>";
		
		$output['aaData'][] = $row;	
    }
			
    echo json_encode( $output );
    pg_close($ipacs);
?>
