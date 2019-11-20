<?php
require("../../Connections/sigma.php");
	// consulta para sigma
	//echo date('His');
	if ( (date('His') >= 200000) and (date('His') <= 235959) or (date('His') >= 0) and (date('His') <= 75959) ){  
		$aColumns = array('clave_usuario' , 'u.nombre_usuario', 'u.apellido_paterno_usuario','u.apellido_materno_usuario', 'a.nombre_a', 'u.precio_consulta_extra', 'u.comision_consulta_clinica', 'u.precio_consulta_extra' );
	}else{
		$aColumns = array('clave_usuario' , 'u.nombre_usuario', 'u.apellido_paterno_usuario','u.apellido_materno_usuario', 'a.nombre_a', 'u.precio_consulta_normal', 'u.comision_consulta_clinica', 'u.precio_consulta_extra' );
	}
     
    // DB tables to use 
    $aTables = array( 'usuarios u');
     
    // Indexed column (used for fast and accurate table cardinality) 
    $sIndexColumn = "u.id_u";
     
	 // Joins   
	$sJoin = 'left JOIN areas a ON a.id_a = u.area_usuario and u.puesto IS NOT NULL';//, sucursales s';
	   
	 
    // CONDITIONS 
    $sWhere = "WHERE u.puesto like '%MEDICO%' " ;

//and id_paciente = id and id_programa = 1 
//and id = id_umedica GROUP BY id ";
	 
	 //fin consulta para sigma
	 
	 mysql_select_db($database_sigma, $sigma);
     
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
     
    $rResult = mysql_query( $sQuery, $sigma ) or die(mysql_error());
     
    /* Data set length after filtering */
    $sQuery = "
        SELECT FOUND_ROWS()
    ";
    $rResultFilterTotal = mysql_query( $sQuery, $sigma ) or die(mysql_error());
    $aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
    $iFilteredTotal = $aResultFilterTotal[0];
     
    /* Total data set length */
    $sQuery = "
        SELECT COUNT(".$sIndexColumn.")
        FROM   ".$aTables[0];
     
    $rResultTotal = mysql_query( $sQuery, $sigma ) or die(mysql_error());
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
			//if ($i == 6 or $i==7){continue;}
            if ( $aColumns[$i] == "version" )
            {
                /* Special output formatting for 'version' column */
                $row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ];
            }
            else if ( $aColumns[$i] != ' ' )
            {
                /* General output */
				
				//if ($i==0){
					//$row[0] = $row[] = $aRow[6].$aRow[0];
				//}else{$row[] = $aRow[$i];}
					$row[] = $aRow[$i];
            }
			
        }
		
		/*$row[] = "<input name='select_medico' type='checkbox' id='select_medico' value='$row[0]'>*/
		$row[7] = "
		<img src='../imagenes/pagina_visitas/seleccionado.png' width='25' class='opacidad_0' height='20'>
		";
		$output['aaData'][] = $row;
        //$output['aaData'][] = $row;
		
    }
     
    echo json_encode( $output );
	 mysql_close($sigma);
?>