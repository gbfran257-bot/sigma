<?php
require("../../Connections/horizonte.php"); 
    /* Array of database columns which should be read and sent back to DataTables. Use a space where * you want to insert a non-database field (for example a counter or static image) */
	
	$aColumns = array('v.id_vc', 'p.nombre_completo_p', 'concat(v.referencia_vc,"/",v.contador_vc)', 'v.id_vc', 'v.id_vc', 'v.id_vc', 'v.id_vc', 'v.id_vc', 'v.id_vc', 'v.id_vc', 'v.id_vc', 'v.id_vc', 'v.id_vc', 'v.id_vc', 'v.id_vc', 'v.id_vc', 'v.id_vc', 'v.id_vc', 'v.id_vc', 'v.id_vc', 'v.id_vc', 'v.id_vc', 'v.id_vc', 'v.id_vc', 'v.id_vc', 'v.id_vc', 'v.id_vc', 's.nombre_su', 'a.nombre_a', 'v.area_vc', 's.clave_su', 'a.nombre_a', 'es.estatus_est', 'e.concepto_to' );
     
    // DB tables to use 
    $aTables = array( 'venta_conceptos v');
     
    // Indexed column (used for fast and accurate table cardinality) 
    $sIndexColumn = "v.id_vc";
     
	 // Joins   
	$sJoin = 'left JOIN pacientes p ON p.id_p = v.id_paciente_vc left join conceptos e on e.id_to = v.id_concepto_es left join estatus es on es.id_est = v.estatus_vc left join areas a on a.id_a = v.area_vc left join sucursales s on s.id_su = v.id_sucursal_vc';
	
	if($_GET['acceso']!=1){
		if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
		 $sWhere="WHERE v.fecha_venta_vc BETWEEN '$_GET[min]' AND '$_GET[max]' and p.id_p = v.id_paciente_vc and v.tipo_concepto_vc = 3 and v.temporal_vc = 0 and v.id_sucursal_vc = '$_GET[sucu]' and e.id_area_to = 7 ";
		}else{
		 $sWhere = "WHERE p.id_p = v.id_paciente_vc and v.tipo_concepto_vc = 3 and v.temporal_vc = 0 and v.id_sucursal_vc = '$_GET[sucu]' and e.id_area_to = 7 ";
		}
	}else{
		if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
		 $sWhere="WHERE v.fecha_venta_vc BETWEEN '$_GET[min]' AND '$_GET[max]' and p.id_p = v.id_paciente_vc and v.tipo_concepto_vc = 3 and v.temporal_vc = 0 and e.id_area_to = 7 ";
		}else{
		 $sWhere = "WHERE p.id_p = v.id_paciente_vc and v.tipo_concepto_vc = 3 and v.temporal_vc = 0 and e.id_area_to = 7 ";
		}
	}
	
    /* Database connection information */
    $gaSql['user']       = $username_horizonte; $gaSql['password']   = $password_horizonte; $gaSql['db']         = $database_horizonte; $gaSql['server']     = $hostname_horizonte;
 
     
    $gaSql['link'] =  mysql_pconnect( $gaSql['server'], $gaSql['user'], $gaSql['password']  ) or die( 'Could not open connection to server' );
     
    mysql_select_db( $gaSql['db'], $gaSql['link'] ) or die( 'Could not select database '. $gaSql['db'] );
     
    /*  * Paging */
    $sLimit = "";
    if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
    {
        $sLimit = "LIMIT ".mysql_real_escape_string( $_GET['iDisplayStart'] ).", ".
            mysql_real_escape_string( $_GET['iDisplayLength'] );
    }
     
     
    /* * Ordering */
    $sOrder = "ORDER BY v.id_vc desc";
    if ( isset( $_GET['iSortCol_0'] ) )
    {
        $sOrder = "ORDER BY ";
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
		$row1 = array();
        for ( $j=0 ; $j<count($aColumns) ; $j++ )
        {
            if ( $aColumns[$j] == "version" ) { $row1[] = ($aRow[ $aColumns[$j] ]=="0") ? '-' : $aRow[ $aColumns[$j] ]; }
            else if ( $aColumns[$j] != ' ' ) { $row1[] = $aRow[$j]; }
        }
		$row[0]=$hh;
		
		mysql_select_db($database_horizonte, $horizonte);
		$consulta = "SELECT r.id_rl from resultados_laboratorio r left join bases b on b.id_b = r.id_base_rl where r.id_estudio_vc_rl = $row[3] and b.base_b like '%GLUCOSA%' ";
		$query = mysql_query($consulta) or die (mysql_error());
		while ($fila = mysql_fetch_array($query)) {
			//$lista = $lista.','.$fila['id_rl'];
			$gluc = $fila['id_rl']; 
			mysql_select_db($database_horizonte, $horizonte);
			$resultGL = mysql_query("SELECT r_rango_rl from resultados_laboratorio where id_rl = $gluc ", $horizonte) or die (mysql_error());
			$rowGL = mysql_fetch_row($resultGL); $row[3]=$rowGL[0];
		};
		
		//Para la Urea
		if($fila['base_b']=='UREA'){
			mysql_select_db($database_horizonte, $horizonte);
			$resultU = mysql_query("SELECT r_rango_rl from resultados_laboratorio where id_rl = $gluc ", $horizonte) or die (mysql_error());
			$rowU = mysql_fetch_row($resultU); $row[4]=$rowU[0];
		}else{$row[4]='';}
		if($fila['base_b']=='CREATININA'){
			mysql_select_db($database_horizonte, $horizonte);
			$resultCR = mysql_query("SELECT r_rango_rl from resultados_laboratorio where id_rl = $gluc ", $horizonte) or die (mysql_error());
			$rowCR = mysql_fetch_row($resultCR); $row[5]=$rowCR[0];
		}else{$row[5]='';}
		if($fila['base_b']=='CREATININA'){
			mysql_select_db($database_horizonte, $horizonte);
			$resultCR = mysql_query("SELECT r_rango_rl from resultados_laboratorio where id_rl = $gluc ", $horizonte) or die (mysql_error());
			$rowCR = mysql_fetch_row($resultCR); $row[5]=$rowCR[0];
		}else{$row[5]='';}
			
		//Para la AU
		mysql_select_db($database_horizonte, $horizonte);
 		$resultAU = mysql_query("SELECT r_rango_rl from resultados_laboratorio where id_rl = $row[6] ", $horizonte) or die (mysql_error());
 		$rowAU = mysql_fetch_row($resultAU); $row[6]=$rowAU[0];
		
		//Para la COL
		mysql_select_db($database_horizonte, $horizonte);
 		$resultCOL = mysql_query("SELECT r_valor_nma_rl from resultados_laboratorio where id_rl = $row[7] ", $horizonte) or die (mysql_error());
 		$rowCOL = mysql_fetch_row($resultCOL); $row[7]=$rowCOL[0];
		
		//Para la TG
		mysql_select_db($database_horizonte, $horizonte);
 		$resultTG = mysql_query("SELECT r_rango_rl from resultados_laboratorio where id_rl = $row[8] ", $horizonte) or die (mysql_error());
 		$rowTG = mysql_fetch_row($resultTG); $row[8]=$rowTG[0];
		
		//Para la HDL
		mysql_select_db($database_horizonte, $horizonte);
 		$resultHDL = mysql_query("SELECT r_valor_nma_i_rl from resultados_laboratorio where id_rl = $row[9] ", $horizonte) or die (mysql_error());
 		$rowHDL = mysql_fetch_row($resultHDL); $row[9]=$rowHDL[0];
		
		//Para la LDL
		mysql_select_db($database_horizonte, $horizonte);
 		$resultLDL = mysql_query("SELECT r_valor_nma_rl from resultados_laboratorio where id_rl = $row[10] ", $horizonte) or die (mysql_error());
 		$rowLDL = mysql_fetch_row($resultLDL); $row[10]=$rowLDL[0];
		
		//Para la VLDL
		mysql_select_db($database_horizonte, $horizonte);
 		$resultVLDL = mysql_query("SELECT r_rango_rl from resultados_laboratorio where id_rl = $row[11] ", $horizonte) or die (mysql_error());
 		$rowVLDL = mysql_fetch_row($resultVLDL); $row[11]=$rowVLDL[0];
		
		//Para la TGO
		mysql_select_db($database_horizonte, $horizonte);
 		$resultTGO = mysql_query("SELECT r_rango_rl from resultados_laboratorio where id_rl = $row[12] ", $horizonte) or die (mysql_error());
 		$rowTGO = mysql_fetch_row($resultTGO); $row[12]=$rowTGO[0];
		
		//Para la TGP
		mysql_select_db($database_horizonte, $horizonte);
 		$resultTGP = mysql_query("SELECT r_rango_rl from resultados_laboratorio where id_rl = $row[13] ", $horizonte) or die (mysql_error());
 		$rowTGP = mysql_fetch_row($resultTGP); $row[13]=$rowTGP[0];
		
		//Para la FAL
		mysql_select_db($database_horizonte, $horizonte);
 		$resultFAL = mysql_query("SELECT r_rango_rl from resultados_laboratorio where id_rl = $row[14] ", $horizonte) or die (mysql_error());
 		$rowFAL = mysql_fetch_row($resultFAL); $row[14]=$rowFAL[0];
		
		//Para la BT
		mysql_select_db($database_horizonte, $horizonte);
 		$resultBT = mysql_query("SELECT r_rango_rl from resultados_laboratorio where id_rl = $row[15] ", $horizonte) or die (mysql_error());
 		$rowBT = mysql_fetch_row($resultBT); $row[15]=$rowBT[0];
		
		//Para la BD
		mysql_select_db($database_horizonte, $horizonte);
 		$resultBD = mysql_query("SELECT r_rango_rl from resultados_laboratorio where id_rl = $row[16] ", $horizonte) or die (mysql_error());
 		$rowBD = mysql_fetch_row($resultBD); $row[16]=$rowBD[0];
		
		//Para la BI
		mysql_select_db($database_horizonte, $horizonte);
 		$resultBI = mysql_query("SELECT r_rango_rl from resultados_laboratorio where id_rl = $row[17] ", $horizonte) or die (mysql_error());
 		$rowBI = mysql_fetch_row($resultBI); $row[17]=$rowBI[0];
		
		//Para la Na
		mysql_select_db($database_horizonte, $horizonte);
 		$resultNa = mysql_query("SELECT r_rango_rl from resultados_laboratorio where id_rl = $row[18] ", $horizonte) or die (mysql_error());
 		$rowNa = mysql_fetch_row($resultNa); $row[18]=$rowNa[0];
		
		//Para la K
		mysql_select_db($database_horizonte, $horizonte);
 		$resultK = mysql_query("SELECT r_rango_rl from resultados_laboratorio where id_rl = $row[19] ", $horizonte) or die (mysql_error());
 		$rowK = mysql_fetch_row($resultK); $row[19]=$rowK[0];
		
		//Para la CL
		mysql_select_db($database_horizonte, $horizonte);
 		$resultCL = mysql_query("SELECT r_rango_rl from resultados_laboratorio where id_rl = $row[20] ", $horizonte) or die (mysql_error());
 		$rowCL = mysql_fetch_row($resultCL); $row[20]=$rowCL[0];
		
		//Para la CK
		mysql_select_db($database_horizonte, $horizonte);
 		$resultCK = mysql_query("SELECT r_rango_rl from resultados_laboratorio where id_rl = $row[21] ", $horizonte) or die (mysql_error());
 		$rowCK = mysql_fetch_row($resultCK); $row[21]=$rowCK[0];
		
		//Para la CK-MB
		mysql_select_db($database_horizonte, $horizonte);
 		$resultCKMB = mysql_query("SELECT r_vmaximo_rl from resultados_laboratorio where id_rl = $row[22] ", $horizonte) or die (mysql_error());
 		$rowCKMB = mysql_fetch_row($resultCKMB); $row[22]=$rowCKMB[0];
		
		$output['aaData'][] = $row;
    }
     
    echo json_encode( $output );
?>