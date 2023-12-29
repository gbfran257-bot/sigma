<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");
    /* Array of database columns which should be read and sent back to DataTables. Use a space where  * you want to insert a non-database field (for example a counter or static image) */
	
	$aColumns = array('ov.id_ov', 'ov.referencia_ov', 'DATE_FORMAT(ov.fecha_venta_ov,"%d/%m/%Y %H:%i:%s")', 'p.clave_t', 'p.tipo_trabajador', 'p.titular', 'CONCAT(p.nombre_p, " ", p.apaterno_p, " ", p.amaterno_p)',
    'p.parentesco', 'p.departamento', 'p.puesto_p', 'ov.id_ov', 'ov.id_ov', 'p.paciente_titular');
     
    // DB tables to use 
    $aTables = array( 'orden_venta ov');
     
    // Indexed column (used for fast and accurate table cardinality) 
    $sIndexColumn = "ov.id_ov";
     
	 // Joins   
	$sJoin = 'LEFT JOIN pacientes p ON p.id_p = ov.id_paciente_ov';
	
	// $sWhere = "WHERE 1 = 1 ";
    mysql_select_db($database_horizonte, $horizonte); 
	$resultAU = mysql_query("SELECT multisucursal_u, idSucursal_u from usuarios where id_u = '$_GET[idU]'",$horizonte) or die (mysql_error());
	$rowAU = mysql_fetch_row($resultAU);
    $id_suc = sqlValue($rowAU[1], "int");
	
	switch($rowAU[0]){
		case 0://Solo vé lo suyo
			if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
			  $sWhere="WHERE ov.fecha_venta_ov BETWEEN '$_GET[min]' AND '$_GET[max]' AND ov.sucursal_ov = $id_suc";
			}else{
			//   $sWhere = "WHERE e.id_tipo_concepto_to = 1 and v.temporal_vc = 0 and v.id_radiologo_externo = '$_GET[idU]' ";
			  $sWhere = "WHERE ov.sucursal_ov = $id_suc ";
			}
		break;
		case 2://Ve todo lo de su sucursal y lo suyo
			if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
			  $sWhere="WHERE ov.fecha_venta_ov BETWEEN '$_GET[min]' AND '$_GET[max]' AND ov.sucursal_ov = $id_suc";
			}else{
			//   $sWhere = "WHERE e.id_tipo_concepto_to = 1 and v.temporal_vc = 0 and (o.sucursal_ov = $id_suc or v.id_radiologo_externo = '$_GET[idU]') ";
			  $sWhere = "WHERE ov.sucursal_ov = $id_suc ";
			}
		break;
		case 1://Ve todo de todas las sucursales
			if(isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != '' && $_GET['max'] != ''){
			  $sWhere="WHERE ov.fecha_venta_ov BETWEEN '$_GET[min]' AND '$_GET[max]' ";
			}else{
			//   $sWhere = "WHERE e.id_tipo_concepto_to = 1 and v.temporal_vc = 0 ";
			  $sWhere = "WHERE 1 = 1 ";
			}
		break;
		default:
			echo 'Ha ocurrido un error';
	}
    //
	
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
        $sOrder = "ORDER BY ov.fecha_venta_ov ASC  ";
        for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ ) { if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" ) { $sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".mysql_real_escape_string( $_GET['sSortDir_'.$i] ) .", "; } }
         
        $sOrder = substr_replace( $sOrder, "", -2 );
        if ( $sOrder == "ORDER BY" ) { $sOrder = ""; }
    }else{
        $sOrder = "ORDER BY ov.fecha_venta_ov DESC ";
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
    $conteo = 0; 

    while ( $aRow = mysql_fetch_array( $rResult ) )
    {
        $conteo++;
        $row = array();
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        { if ( $aColumns[$i] == "version" ) { /* Special output formatting for 'version' column */ $row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ]; } else if ( $aColumns[$i] != ' ' ) { /* General output */ $row[] = $aRow[$i]; } }
		$row1 = array();
        for ( $j=0 ; $j<count($aColumns) ; $j++ ) { if ( $aColumns[$j] == "version" ) { $row1[] = ($aRow[ $aColumns[$j] ]=="0") ? '-' : $aRow[ $aColumns[$j] ]; } else if ( $aColumns[$j] != ' ' ) { $row1[] = $aRow[$j]; } }
		
		/* $row[0]=$conteo;

        $row[1] = "<button type='button' class='btn btn-xs btn-link' onClick='ver_datos_ref($row[7],\"$row[8]\",$row[9],\"$row[1]\",\"$row[2]\")'>$row[1]</button>";
        */

       
        
        mysql_select_db($database_horizonte, $horizonte);
		$result = mysql_query("SELECT vc.id_concepto_es, c.concepto_to, COUNT(concepto_to) FROM venta_conceptos vc LEFT JOIN conceptos c ON c.id_to = vc.id_concepto_es WHERE vc.referencia_vc = '$row[1]' AND c.id_tipo_concepto_to = 5 GROUP BY vc.id_concepto_es", $horizonte) or die (mysql_error());
		while ( $fila = mysql_fetch_row($result) ){
			$cadena=$cadena.'<strong>'.$fila[2].'.</strong>&nbsp;&nbsp;'.$fila[1].'<br>';
            if(isset($fila[2])){
                $contador_productos+=1;
            }
		}
        if($contador_productos<1){
            $conteo--;
            continue;
        }



        if($row[5]==1){
            $row[5] = $row[6];
        }else if($row[5]==0 && isset($row[12])){

            mysql_select_db($database_horizonte, $horizonte); 
            $nom_paciente = mysql_query('SELECT CONCAT(nombre_p, " ", apaterno_p, " ", amaterno_p) from pacientes WHERE id_p = ' . $row[12], $horizonte) or die (mysql_error());
            $nom_comp_p = mysql_fetch_row($nom_paciente);

            $row[5] = $nom_comp_p[0];
        }else{
            $row[5] = "";
        }

        $row[0] = $conteo;
        $row[10] = " ";
        $row[11] = $cadena;

        $cadena = "";
        $contador_productos = 0;
        /* $row[1] = "<div style='text-align:center;'>$row[1]</div>";
        $row[2] = "<div style='text-align:left;'>$row[2]</div>"; */
        

		$output['aaData'][] = $row;
    }
    echo json_encode( $output );
?>