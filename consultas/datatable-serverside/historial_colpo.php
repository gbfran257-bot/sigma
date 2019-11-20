<?php
require("../../Connections/horizonte.php");
	$aColumns = array('vc.id_vc' , 'DATE_FORMAT(vc.fecha_venta_vc,"%d/%c/%Y")', 'c.concepto_to', 'concat(u.nombre_u," ",u.apaterno_u)', 'vc.id_vc', 'vc.tipo_concepto_vc','concat(p.nombre_p," ",p.apaterno_p)','vc.no_temp_vc','vc.referencia_vc','u.amaterno_u','vc.contador_vc','p.id_p','vc.id_vc');
     
    // DB tables to use 
    $aTables = array( 'venta_conceptos vc');
     
    // Indexed column (used for fast and accurate table cardinality) 
    $sIndexColumn = "vc.id_vc";
     
	 // Joins   
	$sJoin = 'left join catalogo_tipo_conceptos t on t.id_tc = vc.tipo_concepto_vc left join conceptos c on c.id_to = vc.id_concepto_es left join pacientes p on p.id_p = vc.id_paciente_vc left join usuarios u on u.id_u = vc.usuarioEdo5_e';
	 
    // CONDITIONS 
    $sWhere="WHERE vc.id_paciente_vc = '$_GET[aleatorio]' and vc.tipo_concepto_vc = 4 and vc.estatus_vc = 5 and vc.area_vc = 85 and temporal_vc = 0 ";

    /* Database connection information */
    $gaSql['user']       = $username_horizonte;
    $gaSql['password']   = $password_horizonte;
    $gaSql['db']         = $database_horizonte;
    $gaSql['server']     = $hostname_horizonte;
 
     
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
        $sOrder = "ORDER BY vc.id_vc desc  ";
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
		
		$row[0]=$hh;
		$x='"'.$row[6].'"';
		$x1='"'.$row[1].'"';
		$x2='"'.$row[7].'"';
		$miRef = substr($row[8], 2); $miRef = str_replace("-","",$miRef);
		$x3='"'.$miRef.$row[10].'"';
		
		if($row[5]==3 || $row[5]==5){
			$row[2]="<div align='left' lang='$row[4]' name='$row[6]' onClick='rDXcol(this.lang,0,$row[11],$x1,$x2,$x3)' class='$row[12] histou'><span style='cursor:pointer;'>$row[2]</span></div>";
		}
		if($row[5]==4){
			$row[2]="<div align='left' lang='$row[4]' name='$row[6]' onClick='rDXcol(this.lang,0,$row[11],$x1,$x2,$x3)' class='$row[12] histou'><span style='cursor:pointer;'>$row[2]</span></div>";
		}
		if($row[5]==1){
			$row[2]="<div align='left' lang='$row[4]' name='$row[6]' onClick='rDXcol(this.lang,0,$row[11],$x1,$x2,$x3)' class='$row[12] histou'><span style='cursor:pointer;'>$row[2]</span></div>";
		}
		$row[3] = $row[3].' '.$row[9];
		$output['aaData'][] = $row;
		
    }
    echo json_encode( $output );
?>