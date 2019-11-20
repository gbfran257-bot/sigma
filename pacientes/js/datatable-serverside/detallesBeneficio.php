<?php
require("../../../Connections/horizonte.php");
	$aColumns = array('cb.id_cb', 't1.concepto_to', 't.tipo_concepto_tc', 'cb.id_concepto_convenio_cb','c.id_ac','c.cantidad_ac', 'c.id_concepto_ac', 'cp.id_cvp', 'DATE_FORMAT(cb.fecha_usado_cb,"%d/%c/%Y")', 'cb.infinito_cb');
     
    // DB tables to use 
    $aTables = array( 'conceptos_beneficios cb');
     
    // Indexed column (used for fast and accurate table cardinality) 
    $sIndexColumn = "cb.id_cb";
     
	 // Joins   
	$sJoin = 'left join asigna_conceptos_convenios c on c.id_ac = cb.id_concepto_convenio_cb left join conceptos t1 on t1.id_to = c.id_concepto_ac left join catalogo_tipo_conceptos t on t.id_tc = t1.id_tipo_concepto_to left join convenios_paciente cp on cp.id_cvp = cb.id_convenio_paciente_cb ';
	   
    // CONDITIONS 
	$sWhere = "WHERE cb.id_convenio_paciente_cb = '$_GET[idB]' group by t1.concepto_to ";

    /* Database connection information */
    $gaSql['user'] = $username_horizonte; $gaSql['password'] = $password_horizonte; $gaSql['db'] = $database_horizonte; $gaSql['server'] = $hostname_horizonte;
     
    $gaSql['link'] =  mysql_pconnect( $gaSql['server'], $gaSql['user'], $gaSql['password']  ) or
        die( 'Could not open connection to server' );
     
    mysql_select_db( $gaSql['db'], $gaSql['link'] ) or 
        die( 'Could not select database '. $gaSql['db'] );
     
     
    /* * Paging */
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
 
        // $c = fopen('../debugging.txt','a+'); // fwrite($c, '$sQuery: '.$sQuery."\n"); // fclose($c);
     
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
    );$hh=0;
     
    while ( $aRow = mysql_fetch_array( $rResult ) )
    {
		$hh++; $cont = 0;
        $row = array();
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        {
            if ( $aColumns[$i] == "version" ) { $row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ]; }
            else if ( $aColumns[$i] != ' ' ) { $row[] = $aRow[$i]; }
        }
		
		mysql_select_db($database_horizonte, $horizonte);
		$result = mysql_query("SELECT fecha_usado_cb, DATE_FORMAT(fecha_usado_cb,'%d/%c/%Y'), infinito_cb from conceptos_beneficios where id_concepto_convenio_cb = $row[3] and id_convenio_paciente_cb = $row[7]", $horizonte) or die (mysql_error()); 
		$row[3]='';
		while ( $rowX = mysql_fetch_row($result) ){ $cont++;
			if($rowX[0]=='' || $row[9]==1){
				$rowX[0]="<img style='cursor:pointer;' title='Disponible' src='../imagenes/generales/_paloma.png' border = '0' width='25' />";}
			else{
				//if($row[9]==1){ }else{ }
				$usado = 'Usado el día '.$rowX[1];
				$rowX[0]="<img title='$usado' style='cursor:pointer;' src='../imagenes/generales/_eliminar.png' border = '0' width='25' />";
			}
			$row[3]=$rowX[0].$row[3];
			
		}
		
		$row[0]=$hh;
		
		if($row[9]==1){
			$row[3]="<img style='cursor:pointer;' title='Disponible' src='../imagenes/generales/_paloma.png' border = '0' width='25' />&nbsp;(# INDEFINIDOS)";
		}
			
		$output['aaData'][] = $row;
    }
    echo json_encode( $output );
?>