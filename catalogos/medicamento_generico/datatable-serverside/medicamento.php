<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

    $id_sucursal = sqlValue($_GET["id_sucursal"], "int");

    /* Array of database columns which should be read and sent back to DataTables. Use a space where  * you want to insert a non-database field (for example a counter or static image) */
	
	$aColumns = array('id_med','clave_med','nombre_generico_med','descripcion_med','id_med','id_med','id_med');
     
    // DB tables to use 
    $aTables = array( 'medicamentos');
     
    // Indexed column (used for fast and accurate table cardinality) 
    $sIndexColumn = "id_med";
     
	 // Joins   
	$sJoin = '';
	
	$sWhere = "WHERE 1 = 1 ";
	
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
    $sOrder = "ORDER BY nombre_generico_med ASC";
    if ( isset( $_GET['iSortCol_0'] ) )
    {
        $sOrder = "ORDER BY nombre_generico_med ASC  ";
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
    );
    //$hh=1;
    while ( $aRow = mysql_fetch_array( $rResult ) )
    {
        $row = array();
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        { if ( $aColumns[$i] == "version" ) { /* Special output formatting for 'version' column */ $row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ]; } else if ( $aColumns[$i] != ' ' ) { /* General output */ $row[] = $aRow[$i]; } }
		$row1 = array();
        for ( $j=0 ; $j<count($aColumns) ; $j++ ) { if ( $aColumns[$j] == "version" ) { $row1[] = ($aRow[ $aColumns[$j] ]=="0") ? '-' : $aRow[ $aColumns[$j] ]; } else if ( $aColumns[$j] != ' ' ) { $row1[] = $aRow[$j]; } }
		//$row [0] = $hh++;
		$nombreU = '"'.$row[2].'"';

        if(isset($_GET['id_sucursal']) && $_GET['id_sucursal'] !== ''){

        //obtenemos minimos y maximos del generico y la sucursal
        $id_generico = $row[0];
        
        mysql_select_db($database_horizonte, $horizonte);
        $qry_datos_generico = mysql_query("SELECT min_mmg, max_mmg FROM max_min_generico WHERE id_suc_mmg = $id_sucursal AND id_generico_mmg = $id_generico", $horizonte) or die (mysql_error());
        $datos_generico = mysql_fetch_row($qry_datos_generico);
		
		$row[2] = "<input type='text' class='form-control input-sm' value='$row[2]' style='width:230px; text-align:left;' id='input_medic_$row[0]'> <button onclick='updateNameMedic($row[0]);' class='btn btn-info btn-xs'><i class='fa fa-floppy-o' aria-hidden='true'></i></button> <button type='button' class='btn btn-info btn-xs' onClick='editar($row[6], $nombreU)'><i class='fa fa-pencil' aria-hidden='true'></i></button>";
        $row[4] = "<input type='number' class='form-control input-sm' value='$datos_generico[0]' style='width:70px; text-align:right;' lang='$id_generico' id='minimo_$id_generico'>";
        $row[5] = "<input type='number' class='form-control input-sm' value='$datos_generico[1]' style='width:70px; text-align:right;' lang='$id_generico' id='maximo_$id_generico'> <button onclick='updateMinMax($id_sucursal, $id_generico);' class='btn btn-info btn-xs'><i class='fa fa-floppy-o' aria-hidden='true'></i></button>";
		$row[6]= "<button type='button' class='btn btn-xs btn-danger' onClick='delete_medicamento($row[6], $nombreU)'><i class='fa fa-trash'></i></button> <button type='button' class='btn btn-xs btn-warning' onClick='verComerciales($row[6])'><i class='fa fa-search'></i></button>";

        }else{
            $row[4] = "";
            $row[5] = "";
            $row[6] = "";
        }

		$output['aaData'][] = $row;
    }
    echo json_encode( $output );
?>