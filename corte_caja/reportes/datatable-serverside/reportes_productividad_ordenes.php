<?php require_once('../../../Connections/horizonte.php'); ?>
<?php require_once("../../../funciones/php/values.php"); ?>
<?php
	// consulta para horizonte
	$obligatorio = 0;
	$aColumns = array('ov.id_ov','ov.referencia_ov','CONCAT_WS(" ", p.nombre_p, p.apaterno_p, p.amaterno_p)','s.nombre_su','CONCAT_WS("<br>", u.nombre_u, DATE_FORMAT(ov.fecha_venta_ov, "%d/%m/%Y %H:%i"))','cfp.forma_pago_fp','ov.subtotal_ov','(ov.adicionales_c_ov+ov.adicionales_p_ov+ov.adicionales_ei_ov+ov.adicionales_el_ov+ov.adicionales_s_ov)','(ov.t_desc_cta+ov.t_desc_img+ov.t_desc_lab+ov.t_desc_serv+ov.t_desc_pro)','ov.gran_total_ov','(SELECT SUM(pago_pag) FROM pagos_ov WHERE referencia_pag = ov.referencia_ov)','(ov.gran_total_ov-(SELECT SUM(pago_pag) FROM pagos_ov WHERE referencia_pag = ov.referencia_ov))','(SELECT COALESCE(sum(c.c_costo),0) FROM conceptos c LEFT JOIN venta_conceptos vc on vc.id_concepto_es = c.id_to WHERE c.id_tipo_concepto_to IN(1,2,3,4) AND vc.referencia_vc = ov.referencia_ov) + (SELECT COALESCE(sum(c.costo_maquila_to),0) FROM conceptos c LEFT JOIN venta_conceptos vc on vc.id_concepto_es = c.id_to WHERE c.id_tipo_concepto_to IN(5) AND vc.referencia_vc = ov.referencia_ov) + (SELECT COALESCE(sum(b.precio_maquila_b),0) FROM asignar_bases ab LEFT JOIN bases b on b.id_b = ab.id_base_ab LEFT JOIN conceptos c on c.aleatorio_c = ab.aleatorio_ab LEFT JOIN venta_conceptos vc on vc.id_concepto_es = c.id_to WHERE vc.referencia_vc = ov.referencia_ov)','(SELECT COALESCE(SUM(honorarios),0) FROM venta_conceptos WHERE referencia_vc = ov.referencia_ov)', 'ov.id_ov');
     
    // DB tables to use 
    $aTables = array( 'orden_venta ov');
     
    // Indexed column (used for fast and accurate table cardinality) 
    $sIndexColumn = "ov.referencia_ov";
     
	 // Joins   hasta aqui
	$sJoin = 'LEFT JOIN pacientes p ON p.id_p = ov.id_paciente_ov LEFT JOIN sucursales s on s.id_su = ov.sucursal_ov LEFT JOIN usuarios u on u.id_u = ov.usuario_ov LEFT JOIN pagos_ov pa on pa.referencia_pag = ov.referencia_ov LEFT JOIN catalogo_forma_pago cfp on cfp.id_fp = pa.forma_pago_pag';
	// left join conceptos to on to. =  left join departamentos d on d.id_d = pa.id_departamento_pag
    // CONDITIONS 
	if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
        $sWhere = "WHERE ov.fecha_venta_ov BETWEEN '$_GET[min]' AND '$_GET[max]'";
    }else{$sWhere = "WHERE 1=1 " ;}

    if(isset($_GET['filtro_pago']) && $_GET['filtro_pago'] > 0){
        $sWhere .= " AND pa.forma_pago_pag = " . $_GET['filtro_pago'];
    }

    if(isset($_GET['filtro_sucursal']) && $_GET['filtro_sucursal'] > 0){
        $sWhere .= " AND ov.sucursal_ov = " . $_GET['filtro_sucursal'];
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
    /* if ( isset( $_GET['iSortCol_0'] ) )
    { */
        $sOrder = "GROUP BY ov.referencia_ov ORDER BY ";
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
		$sOrder = "GROUP BY ov.referencia_ov ORDER BY ov.fecha_venta_ov DESC";
    // }
     
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
     
    while ( $aRow = mysql_fetch_array( $rResult ) )
    {
        $row = array();
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        {
            if ( $aColumns[$i] == "version" ) { $row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ]; }
            else if ( $aColumns[$i] != ' ' )
            {
               $row[] = $aRow[$i];
            }
        }
		$row1 = array();
        for ( $j=0 ; $j<count($aColumns) ; $j++ )
        {
            if ( $aColumns[$j] == "version" ) { $row1[] = ($aRow[ $aColumns[$j] ]=="0") ? '-' : $aRow[ $aColumns[$j] ]; }
            else if ( $aColumns[$j] != ' ' ) { $row1[] = $aRow[$j]; }
        }

		$row[0] = "<img src='imagenes/generales/details_open.png' title='¡Información Adicional' border = '0' />";	
        $row[14] = $row[9]-($row[12]+$row[13]);

        $output['aaData'][] = $row;
    }
    echo json_encode( $output );
?>
