<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");
    /* Array of database columns which should be read and sent back to DataTables. Use a space where  * you want to insert a non-database field (for example a counter or static image) */
	
	$aColumns = array('v.id_vc', 'e.concepto_to', 'cs.cat_sexo', 'v.id_vc', 'v.id_vc', 'v.id_vc', 'v.id_vc', 'v.id_vc', 'e.c_costo','v.id_vc','v.id_vc');
     
    // DB tables to use 
    $aTables = array( 'venta_conceptos v');
     
    // Indexed column (used for fast and accurate table cardinality) 
    $sIndexColumn = "v.id_vc";
     
	 // Joins   
	$sJoin = 'left join orden_venta o on o.referencia_ov = v.referencia_vc left join conceptos e on e.id_to = v.id_concepto_es left JOIN pacientes p ON p.id_p = v.id_paciente_vc left join usuarios m on m.id_u = v.usuarioEdo3_e left join sucursales s on s.id_su = o.sucursal_ov left join titulos t on t.id_ti = m.id_titulo_u left join catalogo_sexos cs on cs.id_sexo = p.sexo_p';
		
    $sWhere="";

        /* Individual column filtering */
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        {
            if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
            {
                if ( $sWhere == "" ) { $sWhere = "WHERE "; } else { $sWhere .= " AND "; }
                $sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
            }
        }
        if ( $sWhere == "" ) { $sWhere = "WHERE "; } else { $sWhere .= " AND "; }
	$sWhere.=" v.fecha_venta_vc BETWEEN '$_GET[min]' AND '$_GET[max]' and  e.id_tipo_concepto_to = 1 and v.temporal_vc=0  and estatus_vc = 6 group by e.concepto_to,cs.cat_sexo ";
	
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
        $sOrder = "ORDER BY v.id_vc desc group by e.concepto_to ";
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
     
     
    /*  * SQL queries  * Get data to display */
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
	$hh=0;
    $resultT = mysql_query("SELECT e.concepto_to, date_format( now(), '%Y' ) - date_format( DATE_FORMAT(p.fNac_p,'%Y/%c/%d'), '%Y' ) - ( date_format( now(), '00-%m-%d') < date_format( DATE_FORMAT(p.fNac_p,'%Y/%c/%d'), '00-%m-%d' )) as edad, cs.cat_sexo  from venta_conceptos v 
        left join orden_venta o on o.referencia_ov = v.referencia_vc 
        left join conceptos e on e.id_to = v.id_concepto_es 
        left JOIN pacientes p ON p.id_p = v.id_paciente_vc 
        left join usuarios m on m.id_u = v.usuarioEdo3_e 
        left join sucursales s on s.id_su = o.sucursal_ov 
        left join titulos t on t.id_ti = m.id_titulo_u 
	    left join catalogo_sexos cs on cs.id_sexo = p.sexo_p  where v.fecha_venta_vc BETWEEN '$_GET[min]' AND '$_GET[max]' and e.id_tipo_concepto_to = 1 and v.temporal_vc=0 and estatus_vc = 6 ", $horizonte) or die(mysql_error());
        $contfN=0;
        $fArray= array();
        $cArray=array();
        $sArray = array();
        while($filaFechas = mysql_fetch_assoc($resultT)){
            $fArray[$contfN] = $filaFechas['edad'];
            $cArray[$contfN] = $filaFechas['concepto_to'];
            $sArray[$contfN] = $filaFechas['cat_sexo'];

            // echo $fArray[$contfN];
            // echo $cArray[$contfN];
            // echo $sArray[$contfN];
            $contfN++;

           
        }
    // $rowT = mysql_fetch_row($resultT);
    while ( $aRow = mysql_fetch_array( $rResult ) )
    {
		$hh++;
        $row = array();
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        { if ( $aColumns[$i] == "version" ) { /* Special output formatting for 'version' column */ $row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ]; } else if ( $aColumns[$i] != ' ' ) { /* General output */ $row[] = $aRow[$i]; } }
		$row1 = array();
        for ( $j=0 ; $j<count($aColumns) ; $j++ ) { if ( $aColumns[$j] == "version" ) { $row1[] = ($aRow[ $aColumns[$j] ]=="0") ? '-' : $aRow[ $aColumns[$j] ]; } else if ( $aColumns[$j] != ' ' ) { $row1[] = $aRow[$j]; } }
		$row[0] = "<span>$hh</span>";
        $row[3] = 0;
        $row[4] = 0;
        $row[5] = 0;
        $row[6] = 0;
        $row[7] = 0;
        $row[8] = 0;
        $row[9] = 0;
        $j= -1;
        do {
            $j++;
            if($row[2] == 'MASCULINO'){
                if($cArray[$j] == $row[1]){
                    $consulta = $row[1];
                    $sexo = 'MASCULINO';
                    for ($i=0; $i < count($cArray); $i++) { 
                        if($cArray[$i] == $consulta && $sArray[$i] == $sexo){
                            if($fArray[$i] <= 5 && $fArray[$i] >= 1){
                                $row[3]++;
                            }elseif ($fArray[$i] <= 12 && $fArray[$i] >= 6) {
                                $row[4]++;
                            }elseif ($fArray[$i] <= 19 && $fArray[$i] >= 13) {
                                $row[5]++;
                            }elseif ($fArray[$i] <= 29 && $fArray[$i] >= 20) {
                                $row[6]++;
                            }elseif ($fArray[$i] <= 49 && $fArray[$i] >= 30) {
                                $row[7]++;
                            }elseif ($fArray[$i] <= 59 && $fArray[$i] >= 50) {
                                $row[8]++;
                            }elseif ($fArray[$i] >= 60) {
                                $row[9]++;
                            }
                        }
                    }
                break;
                }
            }elseif($row[2] == 'FEMENINO'){
                if($cArray[$j] == $row[1]){
                    $consulta = $row[1];
                    $sexo = 'FEMENINO';
                    for ($i=0; $i < count($cArray); $i++) { 
                        if($cArray[$i] == $consulta && $sArray[$i] == $sexo){
                            if($fArray[$i] <= 5 && $fArray[$i] >= 1){
                                $row[3]++;
                            }elseif ($fArray[$i] <= 12 && $fArray[$i] >= 6) {
                                $row[4]++;
                            }elseif ($fArray[$i] <= 19 && $fArray[$i] >= 13) {
                                $row[5]++;
                            }elseif ($fArray[$i] <= 29 && $fArray[$i] >= 20) {
                                $row[6]++;
                            }elseif ($fArray[$i] <= 49 && $fArray[$i] >= 30) {
                                $row[7]++;
                            }elseif ($fArray[$i] <= 59 && $fArray[$i] >= 50) {
                                $row[8]++;
                            }elseif ($fArray[$i] >= 60) {
                                $row[9]++;
                            }
                        }
                    }
                    break;
                }
            }
        } while ($cArray[$j] != $row[1]);
		
           



        $row[10] = $row[3] + $row[4] + $row[5] + $row[6] + $row[7]+ $row[8]+$row[9];
        $contP++;
		$output['aaData'][] = $row;
    }
    echo json_encode( $output );
?>
