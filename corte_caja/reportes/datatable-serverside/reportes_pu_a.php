<?php require_once('../../../Connections/horizonte.php'); ?>
<?php require_once("../../../funciones/php/values.php"); ?>
<?php
	// consulta para horizonte
	$obligatorio = 0;
	$aColumns = array('pa.id_pag', 'concat(u.nombre_u," ",u.apaterno_u)', 'pa.referencia_pag' , 'p.nombre_completo_p', 's.clave_su', 'pa.pago_pag', 'DATE_FORMAT(pa.fecha_pag, "%m/%d/%Y %H:%i:%S")', 'pa.id_pag', 'u.amaterno_u', 'u.usuario_u');
     
    // DB tables to use 
    $aTables = array( 'pagos_ov pa');
     
    // Indexed column (used for fast and accurate table cardinality) 
    $sIndexColumn = "pa.id_pag";
     
	 // Joins   hasta aqui
	$sJoin = 'left join orden_venta ov on ov.referencia_ov = pa.referencia_pag left join pacientes p ON ov.id_paciente_ov = p.id_p left join usuarios u on u.id_u = pa.usuario_pag left join sucursales s on s.id_su = ov.sucursal_ov';
	// left join conceptos to on to. =  left join departamentos d on d.id_d = pa.id_departamento_pag
	 
    // CONDITIONS 
	if(isset($_GET['depto']) && $_GET['depto'] != 'x' && $_GET['depto'] != ''){//para las solicitudes con departamento
		if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
			$sWhere = "WHERE pa.fecha_pag BETWEEN '$_GET[min]' AND '$_GET[max]' and pa.id_departamento_pag = '$_GET[depto]'";
		}else{$sWhere = "WHERE 1=1" ;}
	}else{
		if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
			$sWhere = "WHERE pa.fecha_pag BETWEEN '$_GET[min]' AND '$_GET[max]'";
		}else{$sWhere = "WHERE 1=1 " ;}
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
		$sOrder = "ORDER BY pa.fecha_pag desc";
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
        for ( $i=0 ; $i<count($aColumns) ; $i++ ){ $sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR "; }
        $sWhere = substr_replace( $sWhere, "", -3 );
        $sWhere .= ')';
    }
     
    /* Individual column filtering */
    for ( $i=0 ; $i<count($aColumns) ; $i++ )
    {
        if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
        {
            if ( $sWhere == "" ) { $sWhere = "WHERE "; }else { $sWhere .= " AND "; }
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
    $sQuery = "SELECT FOUND_ROWS()";
    $rResultFilterTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
    $aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
    $iFilteredTotal = $aResultFilterTotal[0];
     
    /* Total data set length */
    $sQuery = "SELECT COUNT(".$sIndexColumn.") FROM   ".$aTables[0];
     
    $rResultTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
    $aResultTotal = mysql_fetch_array($rResultTotal);
    $iTotal = $aResultTotal[0];
     
    /* * Output */
    $output = array("sEcho" => intval($_GET['sEcho']), "iTotalRecords" => $iTotal, "iTotalDisplayRecords" => $iFilteredTotal, "aaData" => array() );
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
			if( $aColumns[$j] == "version" ){ $row1[] = ($aRow[ $aColumns[$j] ]=="0") ? '-' : $aRow[ $aColumns[$j] ]; }else if( $aColumns[$j] != ' ' ) { $row1[] = $aRow[$j]; }
        }
		
		$row[0]=$hh;
		
		$row[1]="$row[1] $row[8]";

		$output['aaData'][] = $row;
    }
    echo json_encode( $output );
?>