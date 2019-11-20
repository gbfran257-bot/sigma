<?php
require("../../Connections/horizonte.php");
	$aColumns = array('ac.id_ac' , 'c.concepto_to', 'ca.tipo_concepto_tc', 'a.nombre_a', 'ac.precio_ac', 'ac.precio_urgencia_ac', 'ac.cantidad_ac', 'ac.id_ac', 'ac.infinito_ac' );
     
    // DB tables to use 
    $aTables = array( 'asigna_conceptos_convenios ac');
     
    // Indexed column (used for fast and accurate table cardinality) 
    $sIndexColumn = "ac.id_ac";
     
	 // Joins   
	$sJoin = 'left join conceptos c on c.id_to = ac.id_concepto_ac left join catalogo_tipo_conceptos ca on ca.id_tc = c.id_tipo_concepto_to left join departamentos d on d.id_d = c.id_departamento_to left join areas a on a.id_a = c.id_area_to ';
	 
    // CONDITIONS 
    $sWhere = "WHERE ac.aleatorio_ac = '$_GET[aleatorio]' ";

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
	$hh=0;
     
    while ( $aRow = mysql_fetch_array( $rResult ) )
    {
		$hh++;
        $row = array();
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        {
            if ( $aColumns[$i] == "version" )
            {
                /* Special output formatting for 'version' column */
                $row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ];
            }
            else if ( $aColumns[$i] != ' ' )
            {
                /* General output */
					$row[] = $aRow[$i];
            }
        }
		$row[0]=$hh;
		
		if($row[4]==''){
			$row[4] = "<span style='text-decoration:underline; cursor:pointer;' lang='$row[7]' onClick='editPrecioBeneficio(this.lang)'>Editar</span>";
		}else{$row[4] = "<span style='text-decoration:underline; cursor:pointer;' lang='$row[7]' onClick='editPrecioBeneficio(this.lang)'>$row[4]</span>";}
		
		if($row[5]==''){
			$row[5] = "<span style='text-decoration:underline; cursor:pointer;' lang='$row[7]' onClick='editPrecioBeneficio(this.lang)'>Editar</span>";
		}else{$row[5] = "<span style='text-decoration:underline; cursor:pointer;' lang='$row[7]' onClick='editPrecioBeneficio(this.lang)'>$row[5]</span>";}
		
		if($row[6]=='' and $row[8]==''){
			$row[6] = "<span style='text-decoration:underline; cursor:pointer;' lang='$row[7]' onClick='editCantidadBeneficio(this.lang)'>Editar</span>";
		}else{
			if($row[8]==1){
				$row[6] = "<span style='text-decoration:underline; cursor:pointer;' lang='$row[7]' onClick='editCantidadBeneficio(this.lang)'>INFINITAS</span>";
			}else{
				$row[6] = "<span style='text-decoration:underline; cursor:pointer;' lang='$row[7]' onClick='editCantidadBeneficio(this.lang)'>$row[6]</span>";
			}
		}
		
		$output['aaData'][] = $row;
    }
    echo json_encode( $output );
?>