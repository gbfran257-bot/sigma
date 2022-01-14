<?php
require("../../../Connections/horizonte.php"); 
    /* Array of database columns which should be read and sent back to DataTables. Use a space where  * you want to insert a non-database field (for example a counter or static image) */
	if(isset($_GET['idSu'])){
		//primero tenemos que saber si existe su tabulador, sino entnces escogemos el tabulador base
		$tabu = $_GET['idSu'].'_precio'; $resultT = mysql_query("SHOW COLUMNS FROM conceptos LIKE '$tabu' ");
		$existsT = (mysql_num_rows($resultT))?TRUE:FALSE;
		if($existsT){ $precio_nor = $_GET['idSu'].'_precio'; $precio_ur = $_GET['idSu'].'_precio_u'; }
		else{ $precio_nor = 'c.precio_to'; $precio_ur = 'c.precio_urgencia_to'; }
		
		$aColumns = array('c.id_to', 'g.nombre_generico_med', 'c.concepto_to', 'g.cantidad_med', 'g.presentacion_med', 'g.via_administracion_med', 'g.nivel_med', 'g.grupo_med','c.costo_maquila_to',$precio_nor, 'c.precio_h', 'c.precio1_to', 'c.id_to','c.linea_c','c.id_to','c.id_to', 'c.id_to', 'c.id_to', 'c.id_to');
	}else{
		$aColumns = array('c.id_to', 'g.nombre_generico_med', 'c.concepto_to', 'g.cantidad_med', 'g.presentacion_med', 'g.via_administracion_med', 'g.nivel_med', 'g.grupo_med','c.costo_maquila_to','c.precio_to', 'c.precio_h', 'c.precio1_to', 'c.id_to','c.linea_c','c.id_to','c.id_to', 'c.id_to', 'c.id_to', 'c.id_to');
	}
     
    // DB tables to use 
    $aTables = array( 'conceptos c');
     
    // Indexed column (used for fast and accurate table cardinality) 
    $sIndexColumn = "c.id_to";
     
	 // Joins   
	$sJoin = 'left join medicamentos g on g.id_med = c.id_medicamento_g';
	
	$sWhere = "where c.id_tipo_concepto_to = 5 ";
	
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
        $sOrder = "ORDER BY v.id_vc desc  ";
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
	$hh=0;

    
    
   
    $id_su = $_GET['idSu'];
    while ( $aRow = mysql_fetch_array( $rResult ) )
    {       
		$hh++;
        $row = array();
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        { if ( $aColumns[$i] == "version" ) { /* Special output formatting for 'version' column */ $row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ]; } else if ( $aColumns[$i] != ' ' ) { /* General output */ $row[] = $aRow[$i]; } }
		$row1 = array();
        for ( $j=0 ; $j<count($aColumns) ; $j++ ) { if ( $aColumns[$j] == "version" ) { $row1[] = ($aRow[ $aColumns[$j] ]=="0") ? '-' : $aRow[ $aColumns[$j] ]; } else if ( $aColumns[$j] != ' ' ) { $row1[] = $aRow[$j]; } }

         /* existencias en el inevntario  */
         $id= $row[14];
         if(!empty($id_su)){
            $query = "
            SELECT SUM(existencias)
            FROM stock_has_bach left JOIN stock s on s.id = id_stock where id_Producto = $id AND s.id_su = $id_su";
         }else{
            $query = "
            SELECT SUM(existencias)
            FROM stock_has_bach left JOIN stock s on s.id = id_stock where id_Producto = $id ";
         }
         $existencia = mysql_query( $query, $gaSql['link'] ) or die(mysql_error());
         $aExistencia = mysql_fetch_array($existencia);
         $existencias = $aExistencia[0];
		
		$row[0]="<span>$hh</span>";
		
		$nombreP = '"'.$row[2].'"';
		
		$row[2] = "<span id='$row[14]' onClick='verMedicamento(this.id, $nombreP);' style='cursor:pointer; text-decoration:underline;'>$row[2]</span>";
        if($existencias != ''){
            $row[12]= $existencias;
        }else{
            $row[12]= 0;
        }
       
		
		$output['aaData'][] = $row;
    }
	
    echo json_encode( $output );
?>
