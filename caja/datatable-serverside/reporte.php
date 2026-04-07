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
			
			/*$query_Recordset1 = "SELECT distinct(vc.id_paciente_vc) FROM pagos_ov p left join venta_conceptos vc on vc.referencia_vc = p.referencia_pag left join conceptos e on e.id_to = vc.id_concepto_es WHERE vc.temporal_vc != 1 and e.id_departamento_to = $row[1] and p.fecha_pag BETWEEN '$_GET[min]' AND '$_GET[max]'";
			$Recordset1 = mysql_query($query_Recordset1, $horizonte) or die(mysql_error());
			$row_Recordset1 = mysql_fetch_assoc($Recordset1);
			$totalRows_Recordset1 = mysql_num_rows($Recordset1);
			$row[2] = $totalRows_Recordset1;*/
            $ali = $row[2];
			
			/*$query_Recordset1a = "SELECT distinct(vc.referencia_vc) FROM pagos_ov p left join venta_conceptos vc on vc.referencia_vc = p.referencia_pag left join conceptos e on e.id_to = vc.id_concepto_es WHERE vc.temporal_vc != 1 and e.id_departamento_to = $row[1] and p.fecha_pag BETWEEN '$_GET[min]' AND '$_GET[max]'";
			$Recordset1a = mysql_query($query_Recordset1a, $horizonte) or die(mysql_error());
			$row_Recordset1a = mysql_fetch_assoc($Recordset1a);
			$totalRows_Recordset1a = mysql_num_rows($Recordset1a);
			$row[1] = $totalRows_Recordset1a;*/

			// $resultTC = mysql_query("SELECT count(vc.id_vc) from pagos_ov p left join venta_conceptos vc on vc.referencia_vc = p.referencia_pag left join conceptos e on e.id_to = vc.id_concepto_es WHERE temporal_vc != 1 and e.id_departamento_to = $ali and p.fecha_pag BETWEEN '$_GET[min]' AND '$_GET[max]'", $horizonte) or die (mysql_error());
            $resultTC = mysql_query("SELECT count(v.id_vc) FROM venta_conceptos v left join conceptos e on e.id_to = v.id_concepto_es WHERE temporal_vc = 0 and e.id_departamento_to = $ali and v.fecha_venta_vc BETWEEN '$_GET[min]' AND '$_GET[max]'", $horizonte) or die (mysql_error());
			
			$resultT = mysql_query("SELECT SUM(p.pago_pag) from pagos_ov p left join venta_conceptos vc on vc.referencia_vc = p.referencia_pag left join conceptos e on e.id_to = vc.id_concepto_es WHERE e.id_departamento_to = $row[3] and p.fecha_pag BETWEEN '$_GET[min]' AND '$_GET[max]' and vc.temporal_vc != 1", $horizonte) or die (mysql_error()); //Sacamos cuanto es el total por departamento de las ventas de conceptos, pero no es la de los pagos
			
		}else{ }
		
		$rowTC = mysql_fetch_row($resultTC); $rowT = mysql_fetch_row($resultT);
		
		$row[2] = $row[2]; $row[3] = $rowTC[0];
		
		//if($rowT[0]==0){$row[0]="<span class='erase1'>$row[0]</span>";} 
		
		$resultTam = mysql_query("SELECT SUM(p.pago_pag) FROM pagos_ov p LEFT JOIN orden_venta ov on ov.referencia_ov = p.referencia_pag WHERE departamento_pa = 4 and ov.fecha_venta_ov BETWEEN '$_GET[min]' AND '$_GET[max]'", $horizonte) or die (mysql_error());
		$rowTam = mysql_fetch_row($resultTam);
		
		$resultTim = mysql_query("SELECT SUM(p.pago_pag) FROM pagos_ov p LEFT JOIN orden_venta ov on ov.referencia_ov = p.referencia_pag WHERE departamento_pa = 2 and ov.fecha_venta_ov BETWEEN '$_GET[min]' AND '$_GET[max]'", $horizonte) or die (mysql_error());
		$rowTim = mysql_fetch_row($resultTim);
		
		$resultTlb = mysql_query("SELECT SUM(p.pago_pag) FROM pagos_ov p LEFT JOIN orden_venta ov on ov.referencia_ov = p.referencia_pag WHERE departamento_pa = 1 and ov.fecha_venta_ov BETWEEN '$_GET[min]' AND '$_GET[max]'", $horizonte) or die (mysql_error());
		$rowTlb = mysql_fetch_row($resultTlb);
		
		$resultTfa = mysql_query("SELECT SUM(p.pago_pag) FROM pagos_ov p LEFT JOIN orden_venta ov on ov.referencia_ov = p.referencia_pag WHERE departamento_pa = 3 and ov.fecha_venta_ov BETWEEN '$_GET[min]' AND '$_GET[max]'", $horizonte) or die (mysql_error());
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


        $saldos = mysql_query("SELECT ov.referencia_ov from pagos_ov p left join orden_venta ov on p.referencia_pag = ov.referencia_ov WHERE p.fecha_pag BETWEEN '$_GET[min]' AND '$_GET[max]' group by ov.referencia_ov", $horizonte) or die (mysql_error());
        $saldoArray  = array();
        $contS = 0;
        $dep = array();
        $totalSaldo1 = 0;
        $totalSaldo2 = 0;
        $totalSaldo4 = 0;
        $totalSaldo3 = 0;
        while ($filaSaldos = mysql_fetch_assoc($saldos)) {
            $saldoArray[$contS] = $filaSaldos['referencia_ov'];
            $dep[$contS] = $filaSaldos['departamento_pa'];
            $contS++;
        }
        for ($i=0; $i < count($saldoArray) ; $i++) { 
                    $arrayCF = array();
                    $arrayPF = array();
                   
                    $ic= 0;
                    $precioL = 0;
                    $precioS = 0;
                    $precioF = 0;
                    $precioI = 0;
                    $cantidadS3 = mysql_query("SELECT ov.gran_total_ov, vc.precio_vc, vc.id_concepto_es from venta_conceptos vc left join pagos_ov p on p.referencia_pag = vc.referencia_vc left join orden_venta ov on p.referencia_pag = ov.referencia_ov WHERE vc.referencia_vc  = '$saldoArray[$i]' group by vc.id_concepto_es ", $horizonte) or die (mysql_error());
                    while ($conceptosF = mysql_fetch_assoc($cantidadS3)) {
                        $arrayCF[$ic] = $conceptosF['id_concepto_es'];
                        $arrayPF[$ic] = $conceptosF['precio_vc'];
                        $ic++;
                    }

                    for ($a=0; $a < count($arrayCF); $a++) { 
                        $queryD = mysql_query("SELECT c.id_departamento_to  from venta_conceptos vc left join conceptos c on c.id_to = vc.id_concepto_es  where vc.referencia_vc = '$saldoArray[$i]' AND c.id_to = $arrayCF[$a]", $horizonte) or die (mysql_error());
                        $rowd = mysql_fetch_row($queryD);
                        if($rowd[0] == 1){
                            $precioL =  $precioL + $arrayPF[$a];
                        }
                        if($rowd[0] == 2){
                            $precioI =  $precioI + $arrayPF[$a];
                        }
                        if($rowd[0] == 3){
                            $precioF =  $precioF + $arrayPF[$a];
                        }
                        if($rowd[0] == 4){
                            $precioS =  $precioS + $arrayPF[$a];
                        }

                    }
                     //saldo laboratorio
                     $queryD1 = mysql_query("SELECT SUM(pago_pag) from pagos_ov where referencia_pag = '$saldoArray[$i]' AND departamento_pa = 1", $horizonte) or die (mysql_error());
                     $rowS1 = mysql_fetch_row($queryD1);
                     $resta1 = $precioL - $rowS1[0];
                     $totalSaldo1 = $totalSaldo1 + $resta1;
                      //saldo imagen
                    $queryD2 = mysql_query("SELECT SUM(pago_pag) from pagos_ov where referencia_pag = '$saldoArray[$i]' AND departamento_pa = 2", $horizonte) or die (mysql_error());
                    $rowS2 = mysql_fetch_row($queryD2);
                    $resta2 = $precioI - $rowS2[0];
                    $totalSaldo2 = $totalSaldo2 + $resta2;
                    //saldo farmacia
                    $queryD3 = mysql_query("SELECT SUM(pago_pag) from pagos_ov where referencia_pag = '$saldoArray[$i]' AND departamento_pa = 3", $horizonte) or die (mysql_error());
                    $rowS3 = mysql_fetch_row($queryD3);
                    $resta3 = $precioF - $rowS3[0];
                    $totalSaldo3 = $totalSaldo3 + $resta3;
                     //saldo asociasion
                     $queryD4 = mysql_query("SELECT SUM(pago_pag) from pagos_ov where referencia_pag = '$saldoArray[$i]' AND departamento_pa = 4", $horizonte) or die (mysql_error());
                     $rowS4 = mysql_fetch_row($queryD4);
                     $resta4 = $precioS - $rowS4[0];
                     $totalSaldo4 = $totalSaldo4 + $resta4;
        }

        //obtenemos el total de la ov y los pagos por departamento para obtener el saldo
        mysql_select_db($database_horizonte, $horizonte);

        $qryTotalAsoc = mysql_query("SELECT sum(total_c)+sum(total_s), sum(total_p), sum(total_ei), sum(total_el) FROM orden_venta WHERE fecha_venta_ov BETWEEN '$_GET[min]' AND '$_GET[max]'", $horizonte) or die (mysql_error());
		$totalAsoc = mysql_fetch_row($qryTotalAsoc);

        $qryPacientes = mysql_query("select count(distinct vc.id_paciente_vc) from venta_conceptos vc left join conceptos c on c.id_to = vc.id_concepto_es where c.id_departamento_to = $row[1] and vc.fecha_venta_vc BETWEEN '$_GET[min]' AND '$_GET[max]' and referencia_vc is not null", $horizonte) or die (mysql_error());
        $pacientes = mysql_fetch_row($qryPacientes);
        $row[2] = $pacientes[0];

        $qryVisitas = mysql_query("select count(distinct vc.referencia_vc) from venta_conceptos vc left join conceptos c on c.id_to = vc.id_concepto_es where vc.fecha_venta_vc BETWEEN '$_GET[min]' AND '$_GET[max]' and referencia_vc is not null and c.id_departamento_to = $row[1]", $horizonte) or die (mysql_error());
        $visitas = mysql_fetch_row($qryVisitas);
        $row[1] = $visitas[0];

        //Asociación médica
		if($row[6]==4){$row[5] = $totalAsoc[0] - $rowTam[0];}
		//Imagen
		else if($row[6]==2){$row[5] = $totalAsoc[2] - $rowTim[0];}
		//Laboratorio
		else if($row[6]==1){$row[5] = $totalAsoc[3] - $rowTlb[0]; }
		//Farmacia si es que hay conceptos de farmacia
		else if($row[6]==3){$row[5] = $totalAsoc[1] - $rowTfa[0];}
		//Enfermería si es que hay conceptos de Enfermería
				
		$output['aaData'][] = $row;
    }
    echo json_encode( $output );
?>
