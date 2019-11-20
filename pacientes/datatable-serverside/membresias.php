<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");
    /* Array of database columns which should be read and sent back to DataTables. Use a space where  * you want to insert a non-database field (for example a counter or static image) */
	
	$aColumns = array('m.id_me', 'concat(p.nombre_p," ", p.apaterno_p)', 'm.fecha_i_me', 'm.fecha_f_me', 'm.costo_me', 'concat(u.nombre_u," ", u.apaterno_u)', 'm.id_me', 'm.id_me','p.amaterno_p', 'u.amaterno_u', 'm.fecha_me', 'id_paciente_me', 'DATEDIFF(m.fecha_f_me, m.fecha_i_me)');
     
    // DB tables to use 
    $aTables = array( 'membresias m');
     
    // Indexed column (used for fast and accurate table cardinality) 
    $sIndexColumn = "m.id_me";
     
	 // Joins   
	$sJoin = 'left JOIN pacientes p ON p.id_p = m.id_paciente_me left join usuarios u on u.id_u = m.id_usuario_me';
	
	if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
	  $sWhere="WHERE m.fecha_i_me BETWEEN '$_GET[min]' AND '$_GET[max]' ";
	}else{
	  $sWhere = "WHERE 1 = 1 ";
	}
	
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
        $sOrder = "ORDER BY m.id_me desc  ";
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
    ); $hh=0;
     
    while ( $aRow = mysql_fetch_array( $rResult ) )
    {
		$hh++;
        $row = array();
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        { if ( $aColumns[$i] == "version" ) { /* Special output formatting for 'version' column */ $row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ]; } else if ( $aColumns[$i] != ' ' ) { /* General output */ $row[] = $aRow[$i]; } }
		$row1 = array();
        for ( $j=0 ; $j<count($aColumns) ; $j++ ) { if ( $aColumns[$j] == "version" ) { $row1[] = ($aRow[ $aColumns[$j] ]=="0") ? '-' : $aRow[ $aColumns[$j] ]; } else if ( $aColumns[$j] != ' ' ) { $row1[] = $aRow[$j]; } }
						
						
		$row[0] = "<div>$hh</div>";				
		$row[1] = "$row[1] $row[8]";
		$row[5] = "$row[5] $row[9]<br>$row[10]";
		$row[7] = "<div align='center'><button type='button' class='btn btn-sm btn-danger'><i class='fa fa-trash'></i></button></div>";
		
		//Tiene membresía, checar si está normal, si está en periodo de renovación o si ya está vencida: verde, naranja y rojo
		mysql_select_db($database_horizonte, $horizonte);
		$resultCf = mysql_query("SELECT dias_avisar_membresia_cf from configuracion order by id_cf desc limit 1", $horizonte) or die(mysql_error());
		$rowCf = mysql_fetch_row($resultCf);
		
		if($row[12] > $rowCf[0]){//Normal 1
			$row[6] = "<div align='center'><button class='btn btn-success btn-sm' onClick='membresia($id_pa, $nombreP, 1, $mi_fecha_i, $mi_fecha_f)'>NORMAL</button></div>";
		}else if($row[12] > 0 and $row[12]<= $rowCf[0]){//Renovación 2
			$row[6] = "<div align='center'><button class='btn btn-warning btn-sm' onClick='membresia($id_pa, $nombreP, 2, $costo_m, $periodo_m, $mi_fecha_r_i, $mi_fecha_r_f, $mi_fecha_r_i1, $mi_fecha_r_f1)'>RENOVACIÓN</button></div>";
		}else{//Vencida 3
			$row[6] = "<div align='center'><button class='btn btn-danger btn-sm' onClick='membresia($id_pa, $nombreP, 3, $costo_m, $periodo_m, $mi_fecha_f)'>VENCIDA</button></div>";
		}
		
		$output['aaData'][] = $row;
    }
    echo json_encode( $output );
?>