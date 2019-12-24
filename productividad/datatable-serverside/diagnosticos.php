<?php
require("../../Connections/horizonte.php"); 
    /* Array of database columns which should be read and sent back to DataTables. Use a space where
     * you want to insert a non-database field (for example a counter or static image)
    */
	
	$aColumns = array('d.clave_di', 'd.nombre_di', 'd.id_di','d.id_di', 'd.id_di', 'd.id_di', 'd.id_di', 'd.id_di', 'd.id_di', 'd.id_di', 'd.id_di', 'd.id_di', 'd.id_di', 'd.id_di' );
     
    // DB tables to use 
    $aTables = array( 'diagnosticos d');
     
    // Indexed column (used for fast and accurate table cardinality) 
    $sIndexColumn = "d.id_di";
     
	 // Joins   
	$sJoin = 'left join dx_consultas c on c.id_dx_dxc = d.id_di';
	 
    // CONDITIONS 
	$sWhere = "WHERE d.id_di in (select id_dx_dxc from dx_consultas where temp_dxc = 0) ";
		
    /* Database connection information */
	mysql_select_db($database_horizonte, $horizonte);
	
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
        $sOrder = "group by d.nombre_di ORDER BY d.nombre_di  ";
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
		$row1 = array();
        for ( $j=0 ; $j<count($aColumns) ; $j++ )
        {
            if ( $aColumns[$j] == "version" )
            {
                /* Special output formatting for 'version' column */
                $row1[] = ($aRow[ $aColumns[$j] ]=="0") ? '-' : $aRow[ $aColumns[$j] ];
            }
            else if ( $aColumns[$j] != ' ' )
            {
                /* General output */
				$row1[] = $aRow[$j];
            }
        }

	//Número total de veces que se ha dado el diagnóstico
	mysql_select_db($database_horizonte, $horizonte);
	$resultBR1=mysql_query("select count(id_dxc) from dx_consultas where id_dx_dxc = $row[2] and temp_dxc = 0", $horizonte) or die (mysql_error());
	$rowBR1 = mysql_fetch_row($resultBR1);
	
	//Número total de diagnosticos dados
	mysql_select_db($database_horizonte, $horizonte);
	$resultBR2 = mysql_query("select count(id_dxc) from dx_consultas where temp_dxc = 0", $horizonte) or die (mysql_error());
	$rowBR2 = mysql_fetch_row($resultBR2);
	
	//Número de pacientes con tal DX
	mysql_select_db($database_horizonte, $horizonte);
	$resultBR3 = mysql_query("select count(id_p_dxc) from dx_consultas where id_dx_dxc = $row[3] and temp_dxc = 0", $horizonte) or die (mysql_error());
	$rowBR3 = mysql_fetch_row($resultBR3);
	
	//TOTAL DE MUJERES CON TAL DX
	mysql_select_db($database_horizonte, $horizonte);
	$resultBR3c = mysql_query("select count(d.id_p_dxc) from dx_consultas d left join pacientes p on p.id_p = d.id_p_dxc where d.id_dx_dxc = $row[4] and p.sexo_p = 1 and d.temp_dxc = 0", $horizonte) or die (mysql_error());
	$rowBR3c = mysql_fetch_row($resultBR3c);
	
	//TOTAL DE HOMBRES CON TAL DX
	mysql_select_db($database_horizonte, $horizonte);
	$resultBR3l = mysql_query("select count(d.id_p_dxc) from dx_consultas d left join pacientes p on p.id_p = d.id_p_dxc where d.id_dx_dxc = $row[5] and p.sexo_p = 2 and d.temp_dxc = 0", $horizonte) or die (mysql_error());
	$rowBR3l = mysql_fetch_row($resultBR3l);
	
	//TOTAL DE NIÑAS CON TAL DX
	mysql_select_db($database_horizonte, $horizonte);
	$resultBR3i = mysql_query("select count(d.id_p_dxc) from dx_consultas d left join pacientes p on p.id_p = d.id_p_dxc where d.id_dx_dxc = $row[6] and p.sexo_p = 1 and d.temp_dxc = 0 and TIMESTAMPDIFF(YEAR,p.fNac_p,CURDATE()) < 9", $horizonte) or die (mysql_error());
	$rowBR3i = mysql_fetch_row($resultBR3i);
	
	//TOTAL DE NIÑOS CON TAL DX
	mysql_select_db($database_horizonte, $horizonte);
	$resultBR3s = mysql_query("select count(d.id_p_dxc) from dx_consultas d left join pacientes p on p.id_p = d.id_p_dxc where d.id_dx_dxc = $row[7] and p.sexo_p = 2 and d.temp_dxc = 0 and TIMESTAMPDIFF(YEAR,p.fNac_p,CURDATE()) < 9", $horizonte) or die (mysql_error());
	$rowBR3s = mysql_fetch_row($resultBR3s);
	
	//TOTAL DE JOVENAS CON TAL DX
	mysql_select_db($database_horizonte, $horizonte);
	$resultJA = mysql_query("select count(d.id_p_dxc) from dx_consultas d left join pacientes p on p.id_p = d.id_p_dxc where d.id_dx_dxc = $row[8] and p.sexo_p = 1 and d.temp_dxc = 0 and TIMESTAMPDIFF(YEAR,p.fNac_p,CURDATE()) between 9 and 20", $horizonte) or die (mysql_error());
	$rowJA = mysql_fetch_row($resultJA);
	
	//TOTAL DE JOVENES CON TAL DX
	mysql_select_db($database_horizonte, $horizonte);
	$resultJO = mysql_query("select count(d.id_p_dxc) from dx_consultas d left join pacientes p on p.id_p = d.id_p_dxc where d.id_dx_dxc = $row[9] and p.sexo_p = 2 and d.temp_dxc = 0 and TIMESTAMPDIFF(YEAR,p.fNac_p,CURDATE()) between 9 and 20", $horizonte) or die (mysql_error());
	$rowJO = mysql_fetch_row($resultJO);
	
	//TOTAL DE ADULTAS CON TAL DX
	mysql_select_db($database_horizonte, $horizonte);
	$resultATA = mysql_query("select count(d.id_p_dxc) from dx_consultas d left join pacientes p on p.id_p = d.id_p_dxc where d.id_dx_dxc = $row[10] and p.sexo_p = 1 and d.temp_dxc = 0 and TIMESTAMPDIFF(YEAR,p.fNac_p,CURDATE()) between 21 and 64", $horizonte) or die (mysql_error());
	$rowATA = mysql_fetch_row($resultATA);
	
	//TOTAL DE ADULTOS CON TAL DX
	mysql_select_db($database_horizonte, $horizonte);
	$resultATO = mysql_query("select count(d.id_p_dxc) from dx_consultas d left join pacientes p on p.id_p = d.id_p_dxc where d.id_dx_dxc = $row[11] and p.sexo_p = 2 and d.temp_dxc = 0 and TIMESTAMPDIFF(YEAR,p.fNac_p,CURDATE()) between 21 and 64", $horizonte) or die (mysql_error());
	$rowATO = mysql_fetch_row($resultATO);
	
	//TOTAL DE ANCIANAS CON TAL DX
	mysql_select_db($database_horizonte, $horizonte);
	$resultANA = mysql_query("select count(d.id_p_dxc) from dx_consultas d left join pacientes p on p.id_p = d.id_p_dxc where d.id_dx_dxc = $row[12] and p.sexo_p = 1 and d.temp_dxc = 0 and TIMESTAMPDIFF(YEAR,p.fNac_p,CURDATE()) > 64", $horizonte) or die (mysql_error());
	$rowANA = mysql_fetch_row($resultANA);
	
	//TOTAL DE ANCIANOS CON TAL DX
	mysql_select_db($database_horizonte, $horizonte);
	$resultANO = mysql_query("select count(d.id_p_dxc) from dx_consultas d left join pacientes p on p.id_p = d.id_p_dxc where d.id_dx_dxc = $row[13] and p.sexo_p = 2 and d.temp_dxc = 0 and TIMESTAMPDIFF(YEAR,p.fNac_p,CURDATE()) > 64", $horizonte) or die (mysql_error());
	$rowANO = mysql_fetch_row($resultANO);
	
	//Promedio de total de diagnosticos dados
	if($rowBR1[0] == 0){$rowBR4 = 0;}else{$rowBR4 = 100*(round($rowBR1[0]/$rowBR2[0],2));} 
	
	//Promedio de MUJERES con tal DX
	if($rowBR3c[0] == 0){$rowBR5 = 0;}else{$rowBR5 = 100*(round($rowBR3c[0]/$rowBR3[0],2));}
	
	//Promedio de HOMBRES con tal DX
	if($rowBR3l[0] == 0){$rowBR3m =0;}else{$rowBR3m = 100*(round($rowBR3l[0]/$rowBR3[0],2));}
	
	//Promedio de NIÑAS con tal DX
	if($rowBR3i[0] == 0){$rowBR3c1 =0;}else{$rowBR3c1 = 100*(round($rowBR3i[0]/$rowBR3[0],2));}
	
	//Promedio de NIÑOS con tal DX
	if($rowBR3s[0] == 0){$rowBR3l1 =0;}else{$rowBR3l1 = 100*(round($rowBR3s[0]/$rowBR3[0],2));}
	
	//Promedio de JOVENAS con tal DX
	if($rowJA[0] == 0){$rowBR3i1 =0;}else{$rowBR3i1 = 100*(round($rowJA[0]/$rowBR3[0],2));}
	
	//Promedio de JOVENES con tal DX
	if($rowJO[0] == 0){$rowBR3s1 =0;}else{$rowBR3s1 = 100*(round($rowJA[0]/$rowBR3[0],2));}
	
	//Promedio de ADULTAS con tal DX
	if($rowATA[0] == 0){$rowBR3i1a =0;}else{$rowBR3i1a = 100*(round($rowATA[0]/$rowBR3[0],2));}
	
	//Promedio de ADULTOS con tal DX
	if($rowATO[0] == 0){$rowBR3s1o =0;}else{$rowBR3s1o = 100*(round($rowATO[0]/$rowBR3[0],2));}
	
	//Promedio de ANCIANAS con tal DX
	if($rowANA[0] == 0){$rowBR3i1an =0;}else{$rowBR3i1an = 100*(round($rowANA[0]/$rowBR3[0],2));}
	
	//Promedio de ANCIANOS con tal DX
	if($rowANO[0] == 0){$rowBR3s1on =0;}else{$rowBR3s1on = 100*(round($rowANO[0]/$rowBR3[0],2));}
		
	$row[2] = $rowBR1[0].'('.$rowBR4.'%)';
	$row[3] = $rowBR3[0];
	$row[4] = $rowBR3c[0].'('.$rowBR5.'%)';
	$row[5] = $rowBR3l[0].'('.$rowBR3m.'%)';
	$row[6] = $rowBR3i[0].'('.$rowBR3c1.'%)';
	$row[7] = $rowBR3s[0].'('.$rowBR3l1.'%)';
	$row[8] = $rowJA[0].'('.$rowBR3i1.'%)';
	$row[9] = $rowJO[0].'('.$rowBR3s1.'%)';
	$row[10] = $rowATA[0].'('.$rowBR3i1a.'%)';
	$row[11] = $rowATO[0].'('.$rowBR3i1o.'%)';
	$row[12] = $rowANA[0].'('.$rowBR3i1an.'%)';
	$row[13] = $rowANO[0].'('.$rowBR3i1on.'%)';
		
		$output['aaData'][] = $row;
    }
     
    echo json_encode( $output );
?>