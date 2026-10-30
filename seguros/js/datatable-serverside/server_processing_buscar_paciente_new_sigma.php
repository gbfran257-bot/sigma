<?php
require("../../Connections/horizonte.php");
    /* Array of database columns which should be read and sent back to DataTables. Use a space where
     * you want to insert a non-database field (for example a counter or static image)
    */
	
	//consulta ORIGINAL
	
    $aColumns = array('id_pa' , 'rc.visitas_rc', 'concat(p.nombre_pa," ", p.apaterno_pa," ", p.amaterno_pa)','p.edad_pa', 'p.sexo_pa', 'p.id_umedica_pa', 's.nombre_su', 'id_pa' );
     
    // DB tables to use 
    $aTables = array( 'pacientes p');
     
    // Indexed column (used for fast and accurate table cardinality) 
    $sIndexColumn = "p.id_pa";
     
	 // Joins   
	$sJoin = 'left JOIN record_paciente rc ON rc.id_paciente_rc = p.id_pa, seguros s';
	//$sJoin = 'left JOIN seguros s ON s.nombre_su = p.sucursal_pa';
	//$sJoin .= 'LEFT JOIN regina_statuses iptv_status ON iptv_status.id = regina_dslams.regie_status_iptv_id ';   
	 
    // CONDITIONS 
    $sWhere = "WHERE s.id_su = p.sucursal_pa and rc.id_paciente_rc = p.id_pa " ;
//and id_paciente = id and id_programa = 1 
//and id = id_umedica GROUP BY id ";
    
	//fin consukta original
	
	/* consulta para sigma
	
	$aColumns = array('id_p' , 'rc.visitas_rc', 'concat(p.nombre_paciente," ", p.apellido_paterno_paciente," ", p.apellido_materno_paciente)','p.fecha_nacimiento_paciente', 'p.sexo_paciente', 'p.id_sucursal_paciente', 's.nombre_su', 'id_p' );
     
    // DB tables to use 
    $aTables = array( 'pacientes p');
     
    // Indexed column (used for fast and accurate table cardinality) 
    $sIndexColumn = "p.id_p";
     
	 // Joins   
	$sJoin = 'left JOIN record_paciente rc ON rc.id_paciente_rc = p.id_p, seguros s';
	//$sJoin = 'left JOIN seguros s ON s.nombre_su = p.sucursal_pa';
	//$sJoin .= 'LEFT JOIN regina_statuses iptv_status ON iptv_status.id = regina_dslams.regie_status_iptv_id ';   
	 
    // CONDITIONS 
    $sWhere = "WHERE s.id_su = p.id_sucursal_paciente and rc.id_paciente_rc = p.id_p " ;
//and id_paciente = id and id_programa = 1 
//and id = id_umedica GROUP BY id ";
	 
	 */
	 
    /* Database connection information */
    $gaSql['user']       = $username_horizonte;
    $gaSql['password']   = $password_horizonte;
    $gaSql['db']         = $database_horizonte;
    $gaSql['server']     = $hostname_horizonte;
 
     
    $gaSql['link'] =  mysql_pconnect( $gaSql['server'], $gaSql['user'], $gaSql['password']  ) or
        die( 'Could not open connection to server' );
     
    mysql_select_db( $gaSql['db'], $gaSql['link'] ) or 
        die( 'Could not select database '. $gaSql['db'] );
     
     
    /* 
     * Paging
    */
    $sLimit = "";
    if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
    {
        $sLimit = "LIMIT ".mysql_real_escape_string( $_GET['iDisplayStart'] ).", ".
            mysql_real_escape_string( $_GET['iDisplayLength'] );
    }
     
     
    /*
     * Ordering
    */
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
        if ( $sOrder == "ORDER BY" )
        {
            $sOrder = "";
        }
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
            if ( $sWhere == "" )
            {
                $sWhere = "WHERE ";
            }
            else
            {
                $sWhere .= " AND ";
            }
            $sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
        }
    }
     
    /*
     * SQL queries
     * Get data to display
    */
    $sQuery = "
        SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
        FROM   ".str_replace(" , ", " ", implode(", ", $aTables))."
		$sJoin
        $sWhere
        $sOrder
        $sLimit";
 
        // $c = fopen('../debugging.txt','a+');
        // fwrite($c, '$sQuery: '.$sQuery."\n");
        // fclose($c);
     
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
     
     
    /*
     * Output
    */
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
			if ($i == 6 or $i==7){continue;}
            if ( $aColumns[$i] == "version" )
            {
                /* Special output formatting for 'version' column */
                $row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ];
            }
            else if ( $aColumns[$i] != ' ' )
            {
                /* General output */
				
				if ($i==0){
					$row[0] = $row[] = $aRow[6].$aRow[0];
				}else{$row[] = $aRow[$i];}
					//$row[] = $aRow[$i];
            }
			//para el sexo
			if ($i==4){
				if ($row[4] == 1 ){
					$row[4] = "M";
				}
				else if ($row[4] == 2 ){
					$row[4] = "F";
				}
				else{
					$row[4] = "";
				}
			}
        }
		$row1 = array();
        for ( $j=0 ; $j<count($aColumns) ; $j++ )
        {
			if (!($j == 6 or $j==7)){continue;}
            if ( $aColumns[$j] == "version" )
            {
                /* Special output formatting for 'version' column */
                $row1[] = ($aRow[ $aColumns[$j] ]=="0") ? '-' : $aRow[ $aColumns[$j] ];
            }
            else if ( $aColumns[$j] != ' ' )
            {
                /* General output */
				
				$row1[] = $aRow[$j];
					//$row[] = $aRow[$i];
            }
        }
		
		$row[] = "<a href='pacientes.php?id={$row1[1]}'> 
		<img src='../imagenes/pagina_pacientes/ok.png' alt='' border = '0' />
		</a>";
		$row[] = "<a href='pacientes.php?id={$row1[1]}'> 
		<img src='../imagenes/pagina_pacientes/bad.png' alt='' border = '0' />
		</a>"; 
		$row[] = "<a href='pacientes.php?id={$row1[1]}'> 
		<img src='../imagenes/pagina_pacientes/visita.png' alt='' border = '0' />
		</a>"; 
		$output['aaData'][] = $row;
        //$output['aaData'][] = $row;
		
    }
     
    echo json_encode( $output );
?>