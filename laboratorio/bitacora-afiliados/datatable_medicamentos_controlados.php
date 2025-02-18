<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");
    /* Array of database columns which should be read and sent back to DataTables. Use a space where  * you want to insert a non-database field (for example a counter or static image) */
	
	$aColumns = array('vc.id_vc', 'DATE_FORMAT(ov.fecha_venta_ov,"%d/%m/%Y")', 'shb.Lote', 'DATE_FORMAT(shb.fecha_expiracion,"%d/%m/%Y")', 'm.nombre_generico_med', 'c.concepto_to', 'cl.nombre_l', 'vc.cantidad', 'ov.doctor', 'ov.cedula');
     
    // DB tables to use 
    $aTables = array( 'venta_conceptos vc');
     
    // Indexed column (used for fast and accurate table cardinality) 
    $sIndexColumn = "vc.id_vc";
     
	 // Joins   
	$sJoin = 'LEFT JOIN conceptos c ON c.id_to = vc.id_concepto_es LEFT JOIN orden_venta ov ON ov.referencia_ov = vc.referencia_vc LEFT JOIN stock_has_bach shb ON shb.id_Producto = c.id_to LEFT JOIN medicamentos m ON m.id_med = c.id_medicamento_g LEFT JOIN catalogo_lineas_cr cl ON cl.nombre_l COLLATE latin1_spanish_ci = c.linea_c COLLATE latin1_spanish_ci';
	
	 $sWhere = "WHERE c.medicamento_controlado = 1 AND ov.no_temp_ov IS NOT NULL AND ov.fecha_venta_ov BETWEEN '$_GET[min]' AND '$_GET[max]'";
   /*  mysql_select_db($database_horizonte, $horizonte); 
	$resultAU = mysql_query("SELECT multisucursal_u, idSucursal_u from usuarios where id_u = '$_GET[idU]'",$horizonte) or die (mysql_error());
	$rowAU = mysql_fetch_row($resultAU);
    $id_suc = sqlValue($rowAU[1], "int");
	
	switch($rowAU[0]){
		case 0:
			if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
			  $sWhere="WHERE ov.fecha_venta_ov BETWEEN '$_GET[min]' AND '$_GET[max]' AND ov.sucursal_ov = $id_suc";
			}else{
			  $sWhere = "WHERE ov.sucursal_ov = $id_suc ";
			}
		break;
		case 2:
			if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
			  $sWhere="WHERE ov.fecha_venta_ov BETWEEN '$_GET[min]' AND '$_GET[max]' AND ov.sucursal_ov = $id_suc";
			}else{
			  $sWhere = "WHERE ov.sucursal_ov = $id_suc ";
			}
		break;
		case 1:
			if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
			  $sWhere="WHERE ov.fecha_venta_ov BETWEEN '$_GET[min]' AND '$_GET[max]' ";
			}else{
			  $sWhere = "WHERE 1 = 1 ";
			}
		break;
		default:
			echo 'Ha ocurrido un error';
	} */
	
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
        $sOrder = "ORDER BY ov.fecha_venta_ov ASC  ";
        for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ ) { if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" ) { $sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".mysql_real_escape_string( $_GET['sSortDir_'.$i] ) .", "; } }
         
        $sOrder = substr_replace( $sOrder, "", -2 );
        if ( $sOrder == "ORDER BY" ) { $sOrder = ""; }
    }else{
        $sOrder = "ORDER BY ov.fecha_venta_ov DESC ";
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
    // $conteo = 0; 

    while ( $aRow = mysql_fetch_array( $rResult ) )
    {
        $conteo++;
        $row = array();
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        { if ( $aColumns[$i] == "version" ) { /* Special output formatting for 'version' column */ $row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ]; } else if ( $aColumns[$i] != ' ' ) { /* General output */ $row[] = $aRow[$i]; } }
		$row1 = array();
        for ( $j=0 ; $j<count($aColumns) ; $j++ ) { if ( $aColumns[$j] == "version" ) { $row1[] = ($aRow[ $aColumns[$j] ]=="0") ? '-' : $aRow[ $aColumns[$j] ]; } else if ( $aColumns[$j] != ' ' ) { $row1[] = $aRow[$j]; } }
		

       /* $row[2] = $row[17] . '<br>' . $row[2];
        
        mysql_select_db($database_horizonte, $horizonte);
		$result = mysql_query("SELECT vc.id_concepto_es, c.concepto_to, COUNT(concepto_to), vc.precio_vc FROM venta_conceptos vc LEFT JOIN conceptos c ON c.id_to = vc.id_concepto_es WHERE vc.referencia_vc = '$row[1]' AND (c.id_tipo_concepto_to = 3 OR c.id_tipo_concepto_to = 4) GROUP BY vc.id_concepto_es", $horizonte) or die (mysql_error());
		while ( $fila = mysql_fetch_row($result) ){
			$cadena=$cadena.'<strong>'.$fila[2].'.</strong>&nbsp;&nbsp;'.$fila[1].'&nbsp; - &nbsp;'.$fila[3].'<br>';
            if(isset($fila[2])){
                $contador_productos+=1;
            }
		}
        if($contador_productos<1){
            $conteo--;
            continue;
        }



        if($row[5]==1){
            $row[5] = $row[6];
        }else if($row[5]==0 && isset($row[12])){

            mysql_select_db($database_horizonte, $horizonte); 
            $nom_paciente = mysql_query('SELECT CONCAT(nombre_p, " ", apaterno_p, " ", amaterno_p) from pacientes WHERE id_p = ' . $row[12], $horizonte) or die (mysql_error());
            $nom_comp_p = mysql_fetch_row($nom_paciente);

            $row[5] = $nom_comp_p[0];
        }else{
            $row[5] = "";
        }

        $row[0] = $conteo;
        $row[10] = " ";
        $row[11] = $cadena;
        $row[12] = $row[13];

        mysql_select_db($database_horizonte, $horizonte); 
        $query_pagos = mysql_query("SELECT COUNT(pago_pag), SUM(pago_pag) FROM pagos_ov WHERE referencia_pag = '".$row[1]."'", $horizonte) or die (mysql_error());
        $revisar_pagos = mysql_fetch_row($query_pagos);
        
        if($revisar_pagos[0]>=1){
            $row[14] = $row[13] - $revisar_pagos[1];
            $row[13] = $revisar_pagos[1];
        }else{
            $row[14] = $row[13];
            $row[13] = "sin pagos";
        }


        $cadena = "";
        $contador_productos = 0; */
        
        $row[0] = $conteo;

		$output['aaData'][] = $row;
    }
    echo json_encode( $output );
?>