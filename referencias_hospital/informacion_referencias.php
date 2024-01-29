<?php
require("../Connections/horizonte.php");
require("../funciones/php/values.php");
    /* Array of database columns which should be read and sent back to DataTables. Use a space where  * you want to insert a non-database field (for example a counter or static image) */
	
	$aColumns = array('ref.id_rh' ,'ref.referencia_rh', 'p.nombre_completo_p', 'CONCAT(u.nombre_u, " ", u.apaterno_u, " ", u.amaterno_u)', 'ref.id_rh', 'ref.id_rh', 'DATE_FORMAT(ref.fecha_rh,"%d/%m/%Y %H:%i")','ref.id_paciente_rh', 'DATE_FORMAT(ref.fecha_rh,"%Y-%m-%d %H:%i")', 'ref.id_rh','ref.estado_rh');
     
    // DB tables to use 
    $aTables = array( 'referencias_hospital ref');
     
    // Indexed column (used for fast and accurate table cardinality) 
    $sIndexColumn = "ref.id_rh";
     
	 // Joins   
	$sJoin = 'LEFT JOIN pacientes p ON p.id_p = ref.id_paciente_rh LEFT JOIN usuarios u ON u.id_u = ref.usuario_rh';
	
	// $sWhere = "WHERE 1 = 1 ";
    mysql_select_db($database_horizonte, $horizonte); 
	$resultAU = mysql_query("SELECT multisucursal_u, idSucursal_u from usuarios where id_u = '$_GET[idU]'",$horizonte) or die (mysql_error());
	$rowAU = mysql_fetch_row($resultAU);
    $id_suc = sqlValue($rowAU[1], "int");
	
	switch($rowAU[0]){
		case 0://Solo vé lo suyo
			if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
			  $sWhere="WHERE ref.fecha_rh BETWEEN '$_GET[min]' AND '$_GET[max]' AND ref.id_sucursal_rh = $id_suc";
			}else{
			//   $sWhere = "WHERE e.id_tipo_concepto_to = 1 and v.temporal_vc = 0 and v.id_radiologo_externo = '$_GET[idU]' ";
			  $sWhere = "WHERE ref.id_sucursal_rh = $id_suc ";
			}
		break;
		case 2://Ve todo lo de su sucursal y lo suyo
			if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
			  $sWhere="WHERE ref.fecha_rh BETWEEN '$_GET[min]' AND '$_GET[max]' AND ref.id_sucursal_rh = $id_suc";
			}else{
			//   $sWhere = "WHERE e.id_tipo_concepto_to = 1 and v.temporal_vc = 0 and (o.sucursal_ov = $id_suc or v.id_radiologo_externo = '$_GET[idU]') ";
			  $sWhere = "WHERE ref.id_sucursal_rh = $id_suc ";
			}
		break;
		case 1://Ve todo de todas las sucursales
			if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
			  $sWhere="WHERE ref.fecha_rh BETWEEN '$_GET[min]' AND '$_GET[max]' ";
			}else{
			//   $sWhere = "WHERE e.id_tipo_concepto_to = 1 and v.temporal_vc = 0 ";
			  $sWhere = "WHERE 1 = 1 ";
			}
		break;
		default:
			echo 'Ha ocurrido un error';
	}
    //
	
    /* Database connection information */
    $gaSql['user']       = $username_horizonte;
    $gaSql['password']   = $password_horizonte;
    $gaSql['db']         = $database_horizonte;
    $gaSql['server']     = $hostname_horizonte;
 
    $gaSql['link'] =  mysql_pconnect( $gaSql['server'], $gaSql['user'], $gaSql['password']  ) or die( 'Could not open connection to server' );
     
    mysql_select_db( $gaSql['db'], $gaSql['link'] ) or die( 'Could not select database '. $gaSql['db'] );
     
    /*  * Paging */
    $sLimit = "";
    if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' ) { $sLimit = "LIMIT ".mysql_real_escape_string( $_GET['iDisplayStart'] ).", ". mysql_real_escape_string( $_GET['iDisplayLength'] ); }
     
    /* * Ordering */
    $sOrder = "";
    if ( isset( $_GET['iSortCol_0'] ) )
    {
        $sOrder = "ORDER BY u.id_un desc  ";
        for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ ) { if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" ) { $sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".mysql_real_escape_string( $_GET['sSortDir_'.$i] ) .", "; } }
         
        $sOrder = substr_replace( $sOrder, "", -2 );
        if ( $sOrder == "ORDER BY" ) { $sOrder = ""; }
    }
     
    /*  * Filtering * NOTE this does not match the built-in DataTables filtering which does it * word by word on any field. It's possible to do here, but concerned about efficiency * on very large tables, and MySQL's regex functionality is very limited */
 
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
            if ( $sWhere == "" ) { $sWhere = "WHERE "; } else { $sWhere .= " AND "; }
            $sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
        }
    }
     
    /*  * SQL queries  * Get data to display */
    $sQuery = "
        SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
        FROM   ".str_replace(" , ", " ", implode(", ", $aTables))."
		$sJoin
        $sWhere
        $sOrder
        $sLimit"; 

    $rResult = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
     
    /* Data set length after filtering */
    $sQuery = " SELECT FOUND_ROWS() ";
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
     
    /*  * Output */
    $output = array(
        "sEcho" => intval($_GET['sEcho']),
        "iTotalRecords" => $iTotal,
        "iTotalDisplayRecords" => $iFilteredTotal,
        "aaData" => array()
    );
    $conteo = 0; 

    while ( $aRow = mysql_fetch_array( $rResult ) )
    {
        $conteo++;
        $row = array();
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        { if ( $aColumns[$i] == "version" ) { /* Special output formatting for 'version' column */ $row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ]; } else if ( $aColumns[$i] != ' ' ) { /* General output */ $row[] = $aRow[$i]; } }
		$row1 = array();
        for ( $j=0 ; $j<count($aColumns) ; $j++ ) { if ( $aColumns[$j] == "version" ) { $row1[] = ($aRow[ $aColumns[$j] ]=="0") ? '-' : $aRow[ $aColumns[$j] ]; } else if ( $aColumns[$j] != ' ' ) { $row1[] = $aRow[$j]; } }
		//obtenemos gran total de orden de venta
        mysql_select_db($database_horizonte, $horizonte);
        $result_grantotal = mysql_query("SELECT SUM(ov.gran_total_ov) FROM rel_referencias_hospital rrh LEFT JOIN orden_venta ov ON ov.referencia_ov = rrh.referencia_rrh WHERE rrh.id_rh_rrh = $row[9]", $horizonte) or die (mysql_error());
        $datos_grantotal = mysql_fetch_row($result_grantotal);

		//obtenemoS los pagos de las referencias
        mysql_select_db($database_horizonte, $horizonte);
        $result_pagos_ov = mysql_query("SELECT SUM(pag.pago_pag) FROM pagos_ov pag LEFT JOIN rel_referencias_hospital rrh ON rrh.referencia_rrh = pag.referencia_pag WHERE rrh.id_rh_rrh = $row[9]", $horizonte) or die (mysql_error());
        $datos_pagos_ov = mysql_fetch_row($result_pagos_ov);

		//obtenemos el monto abonado de abonos_referencias_hospital
        mysql_select_db($database_horizonte, $horizonte);
        $result_abono = mysql_query("SELECT SUM(cantidad_abonada_arh) FROM abonos_referencias_hospital WHERE id_rh_arh = $row[9]", $horizonte) or die (mysql_error());
        $datos_abono = mysql_fetch_row($result_abono);

        //obtenemos los pagos de las referencias
        mysql_select_db($database_horizonte, $horizonte);
        $result_pagos_ov = mysql_query("SELECT SUM(pag.pago_pag) FROM pagos_ov pag LEFT JOIN rel_referencias_hospital rrh ON rrh.referencia_rrh = pag.referencia_pag WHERE rrh.id_rh_rrh = $row[9]", $horizonte) or die (mysql_error());
        $datos_pagos_ov = mysql_fetch_row($result_pagos_ov);
		
		$row[0]=$conteo;

        $row[1] = "<button type='button' class='btn btn-xs btn-link' onClick='ver_datos_ref($row[7],\"$row[8]\",$row[9],\"$row[1]\",\"$row[2]\")'>$row[1]</button>";

        $row[4] = $datos_grantotal[0];
        $row[5] = $datos_abono[0] + $datos_pagos_ov[0];
        $row[3] = "$row[3] <br> $row[6]";
        $row[6] = ($datos_grantotal[0] - $datos_pagos_ov[0]) - $datos_abono[0];

        if($row[10]==0){
            $estado = "ABIERTO";
        }else if($row[10]==1){
            $estado = "REVISION";
        }else if($row[10]==2){
            $estado = "FACTURACION";
        }else if($row[10]==3){
            $estado = "CERRADO";
        }

        $row[7] = $estado;
		$output['aaData'][] = $row;
    }
    echo json_encode( $output );
?>