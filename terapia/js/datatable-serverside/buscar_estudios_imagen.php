<?php
require("../../../Connections/horizonte.php");

if($_GET['idConvenio']==0){
	$aColumns = array('e.concepto_to', 'a.nombre_a', 'e.precio_to', 'c.convenio_cv', 'e.id_to', 'c.id_cv' );
    // DB tables to use 
    $aTables = array( 'conceptos e');
    // Indexed column (used for fast and accurate table cardinality) 
    $sIndexColumn = "e.id_to";
	 // Joins   
	$sJoin = 'left join areas a on a.id_a = e.id_area_to left join convenios c on c.id_cv = e.id_convenio_to';
    // CONDITIONS
	$lista = '0';
	mysql_select_db($database_horizonte, $horizonte);
	$consulta = "SELECT id_concepto_es from venta_conceptos where no_temp_vc = '$_GET[aleatorio]' and tipo_concepto_vc = 4 ";
	$query = mysql_query($consulta) or die (mysql_error());
	while ($fila = mysql_fetch_array($query)) {
		$lista = $lista.','.$fila['id_concepto_es'];
	};//echo $lista;
	$sWhere = "WHERE e.id_to not in ($lista) and e.id_tipo_concepto_to = 4 ";
}else{
	$aColumns = array('c.concepto_to', 'a.nombre_a', 'acc.precio_ac','cv.convenio_cv', 'c.id_to', 'cv.id_cv', 'cv.id_cv', 'c.id_to', 'cb.id_cb', 'cb.usado_cb');	
	// DB tables to use 
	$aTables = array( 'conceptos_beneficios cb');
	// Indexed column (used for fast and accurate table cardinality) 
	$sIndexColumn = "cb.id_cb";
	 // Joins   
	$sJoin = 'left join convenios_paciente cp on cp.id_cvp = cb.id_convenio_paciente_cb left join convenios cv on cv.id_cv = cp.id_convenio_cvp left join asigna_conceptos_convenios acc on acc.id_ac = cb.id_concepto_convenio_cb left join conceptos c on c.id_to = acc.id_concepto_ac left join areas a on a.id_a = c.id_area_to';
	// CONDITIONS
	$lista = '0';
	mysql_select_db($database_horizonte, $horizonte);
	$consulta="SELECT id_conceptos_beneficios from venta_conceptos where no_temp_vc = '$_GET[aleatorio]' and tipo_concepto_vc = 4 ";
	$query = mysql_query($consulta) or die (mysql_error());
	while ($fila = mysql_fetch_array($query)) {
		$lista = $lista.','.$fila['id_conceptos_beneficios'];
	};//echo $lista;
	$sWhere = "WHERE cb.id_cb not in ($lista) and c.id_tipo_concepto_to = 4 and cv.id_cv = '$_GET[idConvenio]' ";
}

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
		
		if($_GET['idConvenio']==0){
			$row[1]="<span lang='$row[2]'>$row[1]</span>";
			$row[2]="<span lang='0'>$row[2]</span>";
			$row[0]="<span lang='$row[4]'>$row[0]</span>";
			$row[3]="<span lang='$row[5]'>PARTICULAR</span>";
		}
		else{
			if($row[9]==1){
				$row[1] = "<div lang='$row[2]' style='text-decoration:line-through; color:red;'>$row[1]</div>";
				$row[2] = "<div lang='$row[8]' style='text-decoration:line-through; color:red;'>$row[2]</div>";
				$row[0] = "<div lang='$row[4]' class='1' style='text-decoration:line-through; color:red;'>$row[0]</div>";
				$row[3] = "<div lang='$row[5]' style='text-decoration:line-through; color:red;'>$row[3]</div>";
			}else{
				$row[1] = "<div lang='$row[2]'>$row[1]</div>";
				$row[2] = "<div lang='$row[8]'>$row[2]</div>";
				$row[0] = "<div lang='$row[4]'>$row[0]</div>";
				$row[3] = "<div lang='$row[5]'>$row[3]</div>";
			}
		}
		$output['aaData'][] = $row;	
    }     
    echo json_encode( $output );
?>