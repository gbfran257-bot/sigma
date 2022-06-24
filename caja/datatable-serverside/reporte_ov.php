<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

	$aColumns = array('COUNT(o.id_ov)','SUM(o.gran_total_ov)', 'SUM(o.t_desc_cta)+ SUM(o.t_desc_img)+ SUM(o.t_desc_lab)+SUM(o.t_desc_serv) as descuentos');
     
    // DB tables to use 
    $aTables = array('orden_venta o');
     
    // Indexed column (used for fast and accurate table cardinality) 
    $sIndexColumn = " o.id_ov ";
     
	// Joins   
	// $sJoin = 'LEFT JOIN pagos_ov p on p.referencia_pag = o.referencia_ov';

	$sWhere ="WHERE o.fecha_venta_ov BETWEEN '$_GET[min]' AND '$_GET[max]'";
    /* Database connection information */
    $gaSql['user'] = $username_horizonte; $gaSql['password'] = $password_horizonte; 
	$gaSql['db']   = $database_horizonte; $gaSql['server']   = $hostname_horizonte;
     
    $gaSql['link']=mysql_pconnect($gaSql['server'],$gaSql['user'],$gaSql['password']) or die('Could not open connection to server' );
     
    mysql_select_db( $gaSql['db'], $gaSql['link'] ) or die( 'Could not select database '. $gaSql['db'] );
     
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
        for ( $i=0 ; $i<count($aColumns) ; $i++ ) { $sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR "; }
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
        // echo $sQuery;
      
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
            else if ( $aColumns[$i] != ' ' ) { $row[] = $aRow[$i]; }
		}
		$row1 = array();
        for ( $j=0 ; $j<count($aColumns) ; $j++ )
        {
            if ( $aColumns[$j] == "version" ) { $row1[] = ($aRow[ $aColumns[$j] ]=="0") ? '-' : $aRow[ $aColumns[$j] ]; }
            else if ( $aColumns[$j] != ' ' ) { $row1[] = $aRow[$j]; }
        }
		
		//Calculamos el número de pacientes por departamento
		mysql_select_db($database_horizonte, $horizonte);
		
		// if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
			
		// 	$query_Recordset1 = "SELECT distinct(vc.id_paciente_vc) FROM pagos_ov p left join venta_conceptos vc on vc.referencia_vc = p.referencia_pag left join conceptos e on e.id_to = vc.id_concepto_es WHERE vc.temporal_vc != 1 and e.linea_c = '$row[0]' and p.fecha_pag BETWEEN '$_GET[min]' AND '$_GET[max]'";
		// 	$Recordset1 = mysql_query($query_Recordset1, $horizonte) or die(mysql_error());
		// 	$row_Recordset1 = mysql_fetch_assoc($Recordset1);
		// 	$totalRows_Recordset1 = mysql_num_rows($Recordset1);
		// 	$ali = $row[0];
		// 	$row[2] = $totalRows_Recordset1; 
			
		// 	$query_Recordset1a = "SELECT distinct(vc.referencia_vc) FROM pagos_ov p left join venta_conceptos vc on vc.referencia_vc = p.referencia_pag left join conceptos e on e.id_to = vc.id_concepto_es WHERE vc.temporal_vc != 1 and e.linea_c = '$row[0]' and p.fecha_pag BETWEEN '$_GET[min]' AND '$_GET[max]'";
		// 	$Recordset1a = mysql_query($query_Recordset1a, $horizonte) or die(mysql_error());
		// 	$row_Recordset1a = mysql_fetch_assoc($Recordset1a);
		// 	$totalRows_Recordset1a = mysql_num_rows($Recordset1a);
		// 	$row[1] = $totalRows_Recordset1a;
        
        $abonado = mysql_query("SELECT sum(p.pago_pag) from pagos_ov p left join orden_venta ov on p.referencia_pag = ov.referencia_ov WHERE p.fecha_pag BETWEEN '$_GET[min]' AND '$_GET[max]'", $horizonte) or die (mysql_error());
			
        $saldos = mysql_query("SELECT ov.referencia_ov from pagos_ov p left join orden_venta ov on p.referencia_pag = ov.referencia_ov WHERE p.fecha_pag BETWEEN '$_GET[min]' AND '$_GET[max]' GROUP by ov.referencia_ov", $horizonte) or die (mysql_error());
        $saldoArray  = array();
        $contS = 0;
        $totalSaldo = 0;
        while ($filaSaldos = mysql_fetch_assoc($saldos)) {
            $saldoArray[$contS] = $filaSaldos['referencia_ov'];
            $contS++;
        }
        for ($i=0; $i < count($saldoArray) ; $i++) { 
            $cantidadS = mysql_query("SELECT sum(p.pago_pag), ov.gran_total_ov from pagos_ov p left join orden_venta ov on p.referencia_pag = ov.referencia_ov WHERE p.referencia_pag = '$saldoArray[$i]'", $horizonte) or die (mysql_error());
            $rowS = mysql_fetch_row($cantidadS);
            $resta = $rowS[1] - $rowS[0];
            $totalSaldo = $totalSaldo + $resta;
        }
         //Sacamos cuanto es el total por departamento de las ventas de conceptos, pero no es la de los pagos
			
		// }else{ }
		
		// $rowTC = mysql_fetch_row($resultTC); 
        $abonadoR= mysql_fetch_row($abonado);
		
		// $row[2] = $row[2]; 
        $row[3] = $abonadoR[0];
        $row[4] = $totalSaldo;
		
		// $resultTam = mysql_query("SELECT vc.precio_vc FROM venta_conceptos vc left join conceptos c on c.id_to = vc.id_concepto_es left join pagos_ov p on p.referencia_pag = vc.referencia_vc WHERE c.linea_c = '$row[0]' AND vc.temporal_vc = 0 and p.fecha_pag BETWEEN '$_GET[min]' AND '$_GET[max]'", $horizonte) or die (mysql_error());
		// $totalAbonado =  0;
        // $totalSaldo = 0;
        // while ($filaAbonado = mysql_fetch_assoc($resultTam)) {
        //     $totalAbonado = $totalAbonado +$filaAbonado['precio_vc'];
        // }
        // $row[4] = $totalAbonado;
		
				
		$output['aaData'][] = $row;
    }
    echo json_encode( $output );
?>
