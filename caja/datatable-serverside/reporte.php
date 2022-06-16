<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

	$aColumns = array('d.nombre_d', 'd.id_d', 'd.id_d', 'd.id_d', 'd.id_d', 'd.id_d', 'd.id_d', 'd.id_d' );
     
    // DB tables to use 
    $aTables = array('departamentos d');
     
    // Indexed column (used for fast and accurate table cardinality) 
    $sIndexColumn = " d.id_d ";
     
	// Joins   
	$sJoin = ' ';

	$sWhere =" WHERE d.id_d in (1,2,3,4) order by d.nombre_d asc ";
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
		
		if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
			
			$query_Recordset1 = "SELECT distinct(vc.id_paciente_vc) FROM pagos_ov p left join venta_conceptos vc on vc.referencia_vc = p.referencia_pag left join conceptos e on e.id_to = vc.id_concepto_es WHERE vc.temporal_vc != 1 and e.id_departamento_to = $row[1] and p.fecha_pag BETWEEN '$_GET[min]' AND '$_GET[max]'";
			$Recordset1 = mysql_query($query_Recordset1, $horizonte) or die(mysql_error());
			$row_Recordset1 = mysql_fetch_assoc($Recordset1);
			$totalRows_Recordset1 = mysql_num_rows($Recordset1);
			$ali = $row[2];
			$row[2] = $totalRows_Recordset1; 
			
			$query_Recordset1a = "SELECT distinct(vc.referencia_vc) FROM pagos_ov p left join venta_conceptos vc on vc.referencia_vc = p.referencia_pag left join conceptos e on e.id_to = vc.id_concepto_es WHERE vc.temporal_vc != 1 and e.id_departamento_to = $row[1] and p.fecha_pag BETWEEN '$_GET[min]' AND '$_GET[max]'";
			$Recordset1a = mysql_query($query_Recordset1a, $horizonte) or die(mysql_error());
			$row_Recordset1a = mysql_fetch_assoc($Recordset1a);
			$totalRows_Recordset1a = mysql_num_rows($Recordset1a);
			$row[1] = $totalRows_Recordset1a;
			
			// $resultTC = mysql_query("SELECT count(vc.id_vc) from pagos_ov p left join venta_conceptos vc on vc.referencia_vc = p.referencia_pag left join conceptos e on e.id_to = vc.id_concepto_es WHERE temporal_vc != 1 and e.id_departamento_to = $ali and p.fecha_pag BETWEEN '$_GET[min]' AND '$_GET[max]'", $horizonte) or die (mysql_error());
            $resultTC = mysql_query("SELECT count(v.id_vc) FROM venta_conceptos v left join conceptos e on e.id_to = v.id_concepto_es WHERE temporal_vc = 0 and e.id_departamento_to = $ali and v.fecha_venta_vc BETWEEN '$_GET[min]' AND '$_GET[max]'", $horizonte) or die (mysql_error());
			
			$resultT = mysql_query("SELECT SUM(p.pago_pag) from pagos_ov p left join venta_conceptos vc on vc.referencia_vc = p.referencia_pag left join conceptos e on e.id_to = vc.id_concepto_es WHERE e.id_departamento_to = $row[3] and p.fecha_pag BETWEEN '$_GET[min]' AND '$_GET[max]' and vc.temporal_vc != 1", $horizonte) or die (mysql_error()); //Sacamos cuanto es el total por departamento de las ventas de conceptos, pero no es la de los pagos
			
		}else{ }
		
		$rowTC = mysql_fetch_row($resultTC); $rowT = mysql_fetch_row($resultT);
		
		$row[2] = $row[2]; $row[3] = $rowTC[0];
		
		//if($rowT[0]==0){$row[0]="<span class='erase1'>$row[0]</span>";} 
		
		$resultTam = mysql_query("SELECT SUM(p.pago_pag) FROM pagos_ov p WHERE departamento_pa = 4 and p.fecha_pag BETWEEN '$_GET[min]' AND '$_GET[max]'", $horizonte) or die (mysql_error());
		$rowTam = mysql_fetch_row($resultTam);
		
		$resultTim = mysql_query("SELECT SUM(p.pago_pag) FROM pagos_ov p WHERE departamento_pa = 2 and p.fecha_pag BETWEEN '$_GET[min]' AND '$_GET[max]'", $horizonte) or die (mysql_error());
		$rowTim = mysql_fetch_row($resultTim);
		
		$resultTlb = mysql_query("SELECT SUM(p.pago_pag) FROM pagos_ov p WHERE departamento_pa = 1 and p.fecha_pag BETWEEN '$_GET[min]' AND '$_GET[max]'", $horizonte) or die (mysql_error());
		$rowTlb = mysql_fetch_row($resultTlb);
		
		$resultTfa = mysql_query("SELECT SUM(p.pago_pag) FROM pagos_ov p WHERE departamento_pa = 3 and p.fecha_pag BETWEEN '$_GET[min]' AND '$_GET[max]'", $horizonte) or die (mysql_error());
		$rowTfa = mysql_fetch_row($resultTfa);


						
		//Asociación médica
		if($row[6]==4){$row[4] = $rowTam[0];}
		//Imagen
		else if($row[6]==2){$row[4] = $rowTim[0];}
		//Laboratorio
		else if($row[6]==1){$row[4] = $rowTlb[0]; }
		//Farmacia si es que hay conceptos de farmacia
		else if($row[6]==3){$row[4] = $rowTfa[0];}
		//Enfermería si es que hay conceptos de Enfermería



        $resultTamS= mysql_query("SELECT p.pago_pag, ov.gran_total_ov, ov.gran_total_ov - p.pago_pag as saldos FROM orden_venta ov left join pagos_ov p on p.referencia_pag = ov.referencia_ov left join venta_conceptos vc on vc.referencia_vc = ov.referencia_ov WHERE departamento_pa = 4 AND ov.gran_total_ov > p.pago_pag AND vc.temporal_vc = 0  and p.fecha_pag BETWEEN '$_GET[min]' AND '$_GET[max]' GROUP by p.referencia_pag", $horizonte) or die (mysql_error());
        $totalSaldo1 = 0;
        $totalSaldo2 = 0;
        $totalSaldo4 = 0;
        $totalSaldo3 = 0;
        while ($filasTamS = mysql_fetch_assoc($resultTamS)) {
            $totalSaldo4 = $totalSaldo4 + $filasTamS['saldos'];
        }

        $resultTfaS = mysql_query("SELECT p.pago_pag, ov.gran_total_ov, ov.gran_total_ov - p.pago_pag as saldos FROM orden_venta ov left join pagos_ov p on p.referencia_pag = ov.referencia_ov left join venta_conceptos vc on vc.referencia_vc = ov.referencia_ov WHERE departamento_pa = 3 AND ov.gran_total_ov > p.pago_pag AND vc.temporal_vc = 0  and p.fecha_pag BETWEEN '$_GET[min]' AND '$_GET[max]' GROUP by p.referencia_pag", $horizonte) or die (mysql_error());
		// $rowTfaS = mysql_fetch_row($resultTfaS);
        while ($filasFaS = mysql_fetch_assoc($resultTfaS)) {
            $totalSaldo3 = $totalSaldo3 + $filasFaS['saldos'];
        }
    		
		$resultTimS = mysql_query("SELECT p.pago_pag, ov.gran_total_ov, ov.gran_total_ov - p.pago_pag as saldos FROM orden_venta ov left join pagos_ov p on p.referencia_pag = ov.referencia_ov left join venta_conceptos vc on vc.referencia_vc = ov.referencia_ov WHERE departamento_pa = 2 AND ov.gran_total_ov > p.pago_pag AND vc.temporal_vc = 0  and p.fecha_pag BETWEEN '$_GET[min]' AND '$_GET[max]' GROUP by p.referencia_pag", $horizonte) or die (mysql_error());
		// $rowTimS = mysql_fetch_row($resultTimS);
        while ($filasTimS = mysql_fetch_assoc($resultTimS)) {
            $totalSaldo2 = $totalSaldo2 + $filasTimS['saldos'];
        }
		
		$resultTlbS = mysql_query("SELECT p.pago_pag, ov.gran_total_ov, ov.gran_total_ov - p.pago_pag as saldos FROM orden_venta ov left join pagos_ov p on p.referencia_pag = ov.referencia_ov left join venta_conceptos vc on vc.referencia_vc = ov.referencia_ov WHERE departamento_pa = 2 AND ov.gran_total_ov > p.pago_pag AND vc.temporal_vc = 0  and p.fecha_pag BETWEEN '$_GET[min]' AND '$_GET[max]' GROUP by p.referencia_pag", $horizonte) or die (mysql_error());
		// $rowTlbS = mysql_fetch_row($resultTlbS);
        while ($filasTlbS = mysql_fetch_assoc($resultTlbS)) {
            $totalSaldo1 = $totalSaldo1 + $filasTlbS['saldos'];
        }
				

        //Asociación médica
		if($row[6]==4){$row[5] = $totalSaldo4;}
		//Imagen
		else if($row[6]==2){$row[5] = $totalSaldo2;}
		//Laboratorio
		else if($row[6]==1){$row[5] = $totalSaldo1; }
		//Farmacia si es que hay conceptos de farmacia
		else if($row[6]==3){$row[5] = $totalSaldo3;}
		//Enfermería si es que hay conceptos de Enfermería
				
		$output['aaData'][] = $row;
    }
    echo json_encode( $output );
?>
